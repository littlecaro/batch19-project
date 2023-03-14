<?php
    class Home {
        //member variables
        //private is only available inside this class code
        private $_square_meters;
        private $_number_of_floors;
        private $_doors;
        private $_temperature;
        
        //member functions
        //tells where function is available - public avail outside the class
        public function openDoor(){
            //code to open door...
        }
        public function closeDoor(){
            //code to close door...
        }
        public function changeTemperature($temperature){
            //code to update temp...
        }
    }

?>