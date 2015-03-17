<?php

    /**
    * @backupGlobals disabled
    * @backupStaticAttributes disabled
    */
    require_once "src/Task.php";



    $DB = new PDO('pgsql:host=localhost;dbname=to_do_test');

    class TaskTest extends PHPUnit_Framework_TestCase
    {
        protected function tearDown()
        {
            Task::deleteAll();
        }

        function test_getId()
        {
            //Arrage
            $description = "Wash the dog";
            $id = 1;
            $test_Task = new Task($description, $id);

            //Act
            $result = $test_Task->getId();

            //Assert
            $this->assertEquals(1, $result);
        }

        function test_setId()
        {
            //Arrange
            $description = "Wash the dog";
            $id = null;
            $test_Task = new Task($description, $id);

            //Act
            $test_Task->setId(2);

            //Assert
            $result = $test_Task->getId();
            $this->assertEquals(2, $result);

        }

        function test_save()
        {
            //Arrange
            $description = "wash the car";
            $id = null;
            $test_task = new Task($description, $id);

            //Act
            $test_task->save();

            //Assert
            $result = Task::getAll();
            $this->assertEquals($test_task, $result[0]);
        }

        function test_getAll()
        {
            //Arrange
            $description = "wash the car";
            $description2 = "water the lawn";
            $id = null;
            $test_Task = new Task($description, $id);
            $test_Task->save();
            $test_Task2 = new Task($description2, $id);
            $test_Task2->save();

            //Act
            $result = Task::getAll();

            //Assert
            $this->assertEquals([$test_Task, $test_Task2], $result);

        }

        function test_deleteAll()
        {
            //Arrange
            $description = "Wash the dog";
            $description2= "water the lawn";
            $id = null;
            $test_Task = new Task($description, $id);
            $test_Task->save();
            $test_Task2 = new Task($description2, $id);
            $test_Task2->save();

            //Act
            Task::deleteAll();

            //Assert
            $result = Task::getAll();
            $this->assertEquals([], $result);
        }

        function test_find()
        {
            //Arrange
            $description = "watch the dog";
            $id = null;
            $description2 = "water the lawn";
            $test_task = new Task($description, $id);
            $test_task->save();
            $test_task2= new Task($description2, $id);
            $test_task2->save();

            //Act
            $result = Task::find($test_task->getId());

            //Assert
            $this->assertEquals($test_task, $result);


        }



    }



?>
