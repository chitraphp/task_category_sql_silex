<?php
    class Category
    {
        private $name;
        private $id;

        //initializing the variables
        function __construct($name, $id = null)
        {
            $this->name = $name;
            $this->id = $id;
        }

        //setting new value to the name variable
        function setName($new_name)
        {
            $this->name = (string) $new_name;
        }

        //it returns the name
        function getName()
        {
            return $this->name;
        }

        //it returns the id
        function getId()
        {
            return $this->id;
        }

        //it sets new value to the id
        function setId($new_id)
        {
            $this->id = $new_id;
        }

        //saving all the variable values into the categories table by calling query method of (DB) object
        //after inserting name it returns the corresponding id
        //id is set to this returned id
        function save()
        {
            $statement = $GLOBALS['DB']->query("INSERT INTO categories (name)
            VALUES ('{$this->getName()}') RETURNING id;");
            $result = $statement->fetch(PDO::FETCH_ASSOC);
            $this->setId($result['id']);
        }

        //it returns table information in the form of assosiative array
        static function getAll()
        {
            $returned_categories = $GLOBALS['DB']->query("SELECT * FROM categories;");
            $categories = array();
            foreach($returned_categories as $category)
            {
                $name = $category['name'];
                $id = $category['id'];
                $new_category = new Category($name, $id);
                array_push($categories, $new_category);
            }
            return $categories;
        }

        //create a function to find a variable with one condition of id
        static function find($search_id)
        {
            $found_category = null;
            $categories = Category::getAll();
            foreach($categories as $category)
            {
                $category_id = $category->getId();
                if($category_id == $search_id)
                {
                    $found_category = $category;
                }
            }
            return $found_category;
        }

        //the function is to delete all contents of the target table
        static function deleteAll()
        {
            $GLOBALS['DB']->exec("DELETE FROM categories *;");
        }


    }
?>
