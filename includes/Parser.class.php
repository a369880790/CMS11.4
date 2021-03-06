<?php

    class Parser{
        //保存模板内容字段
        private $_tpl;
        //构造方法获取模板文件
        public function __construct($_tplFile){
            if(!$this->_tpl=file_get_contents($_tplFile)){
                exit('ERROR---模板文件读取错误');
            } 
        }
        
        //解析普通变量
        private function parVar(){
            $_patten='/\{\$([\w]+)\}/';
            if(preg_match($_patten, $this->_tpl)){
                $this->_tpl=preg_replace($_patten, "<?php echo \$this->_vars['$1']?>", $this->_tpl);
            }
        }
        
        private function parIf(){
            $_pattenIf='/\{if\s+\$([\w]+)\}/';
            $_pattenEndIf='/\{\/if\}/';
            $_pattenElse='/\{else\}/';
            if(preg_match($_pattenIf, $this->_tpl)){
                if (preg_match($_pattenEndIf, $this->_tpl)){
                    if (preg_match($_pattenElse,$this->_tpl)){
                        $this->_tpl=preg_replace($_pattenElse, "<?php }else{?>", $this->_tpl);
                    }
                    $this->_tpl=preg_replace($_pattenIf, "<?php if(\$this->_vars['$1']){?>", $this->_tpl);
                    $this->_tpl=preg_replace($_pattenEndIf, "<?php }?>", $this->_tpl);
                    
                }else {
                    exit('ERROR---无法找到if的结尾');
                }
            }
        }
        private function parIff(){
            $_pattenIf='/\{iff\s+\@([\w\-\>]+)\}/';
            $_pattenEndIf='/\{\/iff\}/';
            $_pattenElse='/\{else\}/';
            if(preg_match($_pattenIf, $this->_tpl)){
                if (preg_match($_pattenEndIf, $this->_tpl)){
                    if (preg_match($_pattenElse,$this->_tpl)){
                        $this->_tpl=preg_replace($_pattenElse, "<?php }else{?>", $this->_tpl);
                    }
                    $this->_tpl=preg_replace($_pattenIf, "<?php if(\$$1){?>", $this->_tpl);
                    $this->_tpl=preg_replace($_pattenEndIf, "<?php }?>", $this->_tpl);
                    
                }else {
                    exit('ERROR---无法找到iff的结尾');
                }
            }
        }
        //foreach
        private function parForeach(){
            $_pattenForeach='/\{foreach\s+\$([\w]+)\(([\w]+),([\w]+)\)\}/';
            $_pattenEndForeach='/\{\/foreach\}/';
            $_pattenVar='/\{\@([\w]+)([\w\-\>\+].*)\}/';
            if(preg_match($_pattenForeach, $this->_tpl)){
                if (preg_match($_pattenEndForeach, $this->_tpl)){
                    $this->_tpl=preg_replace($_pattenForeach, "<?php foreach(\$this->_vars['$1'] as \$$2=>\$$3){?>", $this->_tpl);
                    $this->_tpl=preg_replace($_pattenEndForeach, "<?php }?>", $this->_tpl);
                    if (preg_match($_pattenVar, $this->_tpl)){
                        $this->_tpl=preg_replace($_pattenVar, "<?php echo \$$1$2?>", $this->_tpl);
                    }
                }else{
                    exit('ERROR---foreach 语句没有结尾');
                }
            }
        }
        //解析for 用于 foreach 内嵌 
        private function parFor(){
            $_pattenFor='/\{for\s+\@([\w\-\>]+)\(([\w]+),([\w]+)\)\}/';
            $_pattenEndFor='/\{\/for\}/';
            $_pattenVar='/\{\@([\w]+)([\w\-\>\+].*)\}/';
            if(preg_match($_pattenFor, $this->_tpl)){
                if (preg_match($_pattenEndFor, $this->_tpl)){
                    $this->_tpl=preg_replace($_pattenFor, "<?php foreach(\$$1 as \$$2=>\$$3){?>", $this->_tpl);
                    $this->_tpl=preg_replace($_pattenEndFor, "<?php }?>", $this->_tpl);
                    if (preg_match($_pattenVar, $this->_tpl)){
                        $this->_tpl=preg_replace($_pattenVar, "<?php echo \$$1$2?>", $this->_tpl);
                    }
                }else{
                    exit('ERROR---for 语句没有结尾');
                }
            }
        }
        //解析include
        private function parInclude(){
            $_patten='/\{include\s+file=(\"|\')([\w\.\-\/]+)(\"|\')\}/';
            
            if (preg_match_all($_patten, $this->_tpl,$_file)){
               foreach ($_file[2]as$_value){
                   if(!file_exists('templates/'.$_value.'.php')){
                       exit('ERROR---include file not exist');
                   }
                   $this->_tpl=preg_replace($_patten,"<?php \$_tpl->create('$2')?>", $this->_tpl);
               }       
            }
        }
        //解析系统变量
        private function parConfig(){
            $_patten='/<!--\{([\w]+)\}-->/';
            if(preg_match($_patten, $this->_tpl)){
                $this->_tpl=preg_replace($_patten, "<?php echo \$this->_config['$1'][0]?>", $this->_tpl);
            }
        }
        //解析PHP注释
        private function parCommon(){
            $_patten='/\{#\}(.*)\{#\}/';
            if (preg_match($_patten,$this->_tpl)){
                $this->_tpl=preg_replace($_patten,'<?php /*$1*/?>',$this->_tpl);
               
            }
        }
        //对外公共方法
        public function compile($_parFile){
            //解析
            $this->parInclude();
            $this->parConfig();
            $this->parForeach();
            $this->parFor();
            $this->parCommon();
            $this->parIf();
            $this->parIff();
            $this->parVar();
            
            //生成
            if (!file_put_contents($_parFile,$this->_tpl)){
                echo 'ERROR---生成编译文件出错';
            }
        }
        
        
        
    }
?>