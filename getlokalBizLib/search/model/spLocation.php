<?php 
	class spLocation
	{
		public $full_address;
		public $location_type;
		public $street_type_id;
		public $street_number;
		public $street;
		public $neighbourhood;
		public $building_no;
		public $entrance;
		public $floor;
		public $appartment;
		
		public function getLocationType(){
			return $this->location_type;
		}
		
		public function getStreetTypeId(){
			return $this->street_type_id;
		}
		
		public function getNeighbourhood(){
			return $this->neighbourhood;
		}
		
		public function getStreetNumber(){
			return $this->street_number;
		}
		
		public function getFullAddress(){
			return $this->full_address;
		}
		
		public function getFullAddressEn(){
			return $this->full_address;
		}
                
        public function getStreet() {
            return $this->street;
        }

        public function getBuildingNo() {
            return $this->building_no;
        }

        public function getEntrance() {
            return $this->entrance;
        }

        public function getFloor() {
            return $this->floor;
        }

        public function getAppartment() {
            return $this->appartment;
        }


	}
?>