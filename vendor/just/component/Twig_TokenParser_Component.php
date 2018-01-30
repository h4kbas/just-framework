<?php
namespace Just\Component;

class Twig_TokenParser_Component extends \Twig_TokenParser{
    
    public function parse(\Twig_Token $token)
    {
        $lineno = $token->getLine();
        $stream = $this->parser->getStream();
        $data = [];
        $data['plugin'] = $stream->expect(\Twig_Token::NAME_TYPE);
        $stream->expect(\Twig_Token::PUNCTUATION_TYPE, '.');
        $data['component'] = $stream->expect(\Twig_Token::NAME_TYPE);
        $data['with'] = null;
        if ($stream->nextIf(\Twig_Token::NAME_TYPE, 'with')) {
            do $data['with'][]= $this->parser->getExpressionParser()->parseExpression();
            while($stream->nextIf(\Twig_Token::PUNCTUATION_TYPE, ','));
        }
        $stream->expect(\Twig_Token::BLOCK_END_TYPE);
        
        $body = $this->parser->subparse(array($this, 'decideComponentEnd'), true);
        $stream->expect(\Twig_Token::BLOCK_END_TYPE);
        return new Twig_Node_Component($data, $body, $lineno, $this->getTag());
    }

    public function decideComponentEnd(\Twig_Token $token)
    {
        return $token->test('endcomponent');
    }

    public function getTag()
    {
        return 'component';
    }
}
