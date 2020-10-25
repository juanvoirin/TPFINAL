<?php
	namespace Models;

	class Cinema {

		private $id;
		private $name;
		private $address;
		private $owner;
        

		public function setId($id) {
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

		public function setAddress($address) {
			$this->address = $address;
		}

		public function getAddress() {
			return $this->address;
		}

		public function setOwner(User $owner){
			$this->owner = $owner;
		}

		public function getOwner(){
			return $this->owner;
		}
		
	}
?>