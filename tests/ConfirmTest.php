<?php
namespace tests;

use icron\confirm\Confirm;
use Yii;

class ConfirmTest extends \PHPUnit_Framework_TestCase
{
    public function testGenerateCode()
    {
        $confirm = $this->getConfirm();
        $code = $confirm->generateCode(4);
        $this->assertEquals(4, strlen($code));
    }

    /**
     * @dataProvider sendDataProvider
     */
    public function testSend($destination, $output)
    {
        $confirm = $this->getConfirm();
        $this->assertTrue($confirm->send($destination));
        $this->assertTrue($confirm->send($destination));
        $data1 = $confirm->getDestinationData($destination);
        $this->assertEquals($output, $data1['count_send'], 'Неверный count_send.');
    }

    public function testConfirm()
    {
        $confirm = $this->getConfirm();
        $destination = '123';
        $confirm->send($destination);
        $codes = $confirm->getCodes($destination);
        $this->assertTrue($this->getConfirm($destination, reset($codes)));
    }

    public function sendDataProvider()
    {
       return [
           ['79297058409', 2], // Данные 1
           ['79263324399', 2], // Данные 2
       ];
    }

    /**
     * @return \PHPUnit_Framework_MockObject_MockObject | Confirm
     * @throws \yii\base\InvalidConfigException
     */
    protected function getConfirm()
    {
        $mock = $this->getMockBuilder('\icron\confirm\Confirm')
            ->setConstructorArgs([['provider' => '\tests\TestProvider']])
            ->setMethods(['getSession'])
            ->getMock();

        $mock->expects($this->any())->method('getSession')->will($this->returnValue(Yii::$app->get('session')));

        return $mock;
    }


}
