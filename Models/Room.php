<?php
    namespace Models;

    class Room {

        private $id;
        private $name;
        private $capacity;
        private $price;
        private $cinema;

        public function setId($id){
            $this->id = $id;
        }

        public function getId() {
			return $this->id;
		}

        public function setName($name) {
			$this->name = $name;
		}

		public function getName() {
			return $this->name;
		}

		public function setCapacity($capacity) {
			$this->capacity = $capacity;
		}

		public function getCapacity() {
			return $this->capacity;
		}

        public function setPrice($price) {
			$this->price = $price;
		}

		public function getPrice() {
			return $this->price;
        }
        
        public function setCinema(Cinema $cinema){
            $this->cinema = $cinema;
        }

        public function getCinema() {
			return $this->cinema;
		}
    }
?>
