<?php
    /**
    * @backupGlobals disabled
    * @backupStaticAttributes disabled
    */

    require_once "src/Category.php";

    //create a database object which connects to local host and database. Then save it in variable DB.
    $DB = new PDO('pgsql:host=localhost;dbname=to_do_test');

    //create a new class
    class CategoryTest extends PHPUnit_Framework_TestCase
    {
        //clearing the database after each test.
        protected function tearDown()
        {
          Category::deleteAll();
        }

        //This function is to test the funtion getName of class Category
        function test_getName()
        {
            //Arrange
            $name = "Work stuff";
            $id = null;
            $test_Category = new Category($name, $id);

            //Act
            $result = $test_Category->getName();

            //Assert
            $this->assertEquals($name, $result);
        }
        //This function is to test the funtion getId of class Category
        function test_getId()
        {
            //Arrange
            $name = "Work stuff";
            $id = 1;
            $test_Category = new Category($name, $id);

            //Act
            $result = $test_Category->getId();

            //Assert
            $this->assertEquals(1, $result);
        }
        // this function tests setting the property 'id' for the new value after object initialization
        function test_setId()
        {
            //Arrange
            $name = "Home stuff";
            $id = null;
            $test_Category = new Category($name, $id);

            //Act
            $test_Category->setId(2);

            //Assert
            $result = $test_Category->getId();
            $this->assertEquals(2, $result);
        }

        //// this function tests save method which saves all entered data(name,id) inserts into categories table
        function test_save()
        {
            //Arrange
            $name = "Work stuff";
            $id = null;
            $test_Category = new Category($name, $id);
            $test_Category->save();

            //Act
            $result = Category::getAll();

            //Assert
            $this->assertEquals($test_Category, $result[0]);
        }

        //This function tests Category::getAll().getAll() retrieves information from the category table
        function test_getAll()
        {
            //Arrange
            $name = "Work stuff";
            $id = null;
            $name2 = "Home stuff";
            $id2 = null;
            $test_Category = new Category($name, $id);
            $test_Category->save();
            $test_Category2 = new Category($name2, $id2);
            $test_Category2->save();

            //Act
            $result = Category::getAll();

            //Assert
            $this->assertEquals([$test_Category, $test_Category2], $result);
        }

        //this tests Category::deleteAll(). deleteAll() method deletes all the information in the table
        function test_deleteAll()
        {
            //Arrange
            $name = "Wash the dog";
            $id = null;
            $name2 = "Home stuff";
            $id2 = null;
            $test_Category = new Category($name, $id);
            $test_Category->save();
            $test_Category2 = new Category($name2, $id2);
            $test_Category2->save();

            //Act
            Category::deleteAll();
            $result = Category::getAll();

            //Assert
            $this->assertEquals([], $result);
        }

        function test_find()
        {
            //Arrange
            $name = "Wash the dog";
            $id = 1;
            $name2 = "Home stuff";
            $id2 = 2;
            $test_Category = new Category($name, $id);
            $test_Category->save();
            $test_Category2 = new Category($name2, $id2);
            $test_Category2->save();

            //Act
            $result = Category::find($test_Category->getId());

            //Assert
            $this->assertEquals($test_Category, $result);
        }
    }


?>
