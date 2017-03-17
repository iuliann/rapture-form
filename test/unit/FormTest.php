<?php

class FormTest extends \PHPUnit_Framework_TestCase
{
    public function testForm()
    {
        $form = new \Rapture\Form\Form('test');
        $form->setElements([
            'username' => [
                'name'  =>  'username',
                'type'  => 'Text',
                'attributes' => [
                    'class' => 'form-control'
                ],
                'meta' => [
                    'help' => 'Your username'
                ]
            ]
        ]);
        $element = $form->getElement('username');

        $this->assertEquals('input', $element->getTag());
        $this->assertEquals(['class' => 'form-control', 'type' => 'text', 'name' => 'username', 'value' => null], $element->getAttributes());
        $this->assertEquals('Your username', $element->getMeta()['help']);
    }
}
