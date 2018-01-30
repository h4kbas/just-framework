<?php
namespace Just\Component;

class Twig_Node_Component extends \Twig_Node
{
    public function __construct($data, $body, $lineno, $tag = null)
    {
        parent::__construct(array('body' => $body ), array('with'=> $data['with'], 'plugin'=> $data['plugin'],  'component' => $data['component']), $lineno, $tag);
    }

    public function compile(\Twig_Compiler $compiler)
    {
		$with = null;
		$plugin = $this->getAttribute('plugin')->getValue();
		$component  = $this->getAttribute('component')->getValue();
		if($this->hasAttribute('with'))
			$with = $this->getAttribute('with');
		componentInit($plugin, $component);
		$is = call_user_func(array($component, 'is'));
		$compiler
		->indent()
			->addDebugInfo($this)
			->write("\$context['__plugin'] = '$plugin';\n")
			->write("\$context['__component'] = '$component';\n")
			->write("componentInit(\$context['__plugin'], \$context['__component']);\n")
			->write("\$context['__class'] = new \$context['__component'](");
		if($with){
			$i = 0;
			$len = count($with);
			foreach($with as $w){
				$compiler
					->subcompile($w);
				if($i != $len - 1){
					$compiler->write(',');
				}
				$i++;
			}
		}

		$compiler
			->write(");\n")
			->write("\$context = array_merge(\$context, \$context['__class']->exports);\n");
			
		if($is == "if"){
			$compiler
				->write("if(\$context['__class']->condition){\n")
				->indent()
					->subcompile($this->getNode('body'))
				->outdent()
				->write("}\n");
			}
		else if($is == "repeat"){
			$compiler
				->write("foreach (\$context['__class']->sequence as ")
				->write("\$context[\$context['__class']->key]")
				->raw(' => ')
				->write("\$context[\$context['__class']->value]")
				->raw("){\n")
				->indent()
					->subcompile($this->getNode('body'))
				->outdent()
				->write("}\n");
		}
		else{
			$compiler->subcompile($this->getNode('body'));
		}
		$compiler
		->write("unset(\$context['__plugin']);\nunset(\$context['__class']);")
		->outdent();
		//dd($compiler->getSource());
    }
}
