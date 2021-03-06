<?php

class DoctrineTest_Reporter_Cli extends DoctrineTest_Reporter{
    public function __construct(){
        $this->formatter = new Doctrine_Cli_AnsiColorFormatter();
    }
    public function paintHeader($name){
        echo $this->formatter->format($name, 'INFO') . "\n";
        echo str_repeat('=', strlen($name)) . "\n";
    }
    public function paintFooter(){
        echo "\n";
        echo "\n";
        foreach ($this->_test->getMessages() as $message) {
            echo $this->formatter->format($message, 'ERROR') . "\n\n";
        }
        echo "\n";
        echo $this->formatter->format("Tested: " . $this->_test->getTestCaseCount() . ' test cases.', 'INFO') . "\n";
        echo $this->formatter->format("Successes: " . $this->_test->getPassCount() . " passes.", 'INFO') . "\n";
        echo $this->formatter->format("Failures: " . $this->_test->getFailCount() . " fails.", $this->_test->getFailCount() ? 'ERROR':'INFO') . "\n";
        echo $this->formatter->format("Number of new Failures: " . $this->_test->getNumNewFails(), $this->_test->getNumNewFails() ? 'ERROR':'INFO') . ' ' . implode(", ", $this->_test->getNewFails()) . "\n";
        echo $this->formatter->format("Number of fixed Failures: " . $this->_test->getNumFixedFails(), $this->_test->getNumFixedFails() ? 'INFO':'HEADER') . ' ' . implode(", ", $this->_test->getFixedFails()) . "\n";
    }
    public function getProgressIndicator(){
        return ".";
    }
}
