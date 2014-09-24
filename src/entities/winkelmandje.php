<?php
class Winkelmandje implements Iterator, Countable{
    private $items = array();
    private $positie = 0;
    private $ids = array();
    
    public function __construct(){
        $this->items = array();
        $this->ids = array(); 
    }
    
    public function isLeeg(){
        return (empty($this->items));
    }
    
    public function addItem(Artikel $item){
        $id = $item->getId();
        if(!$id) throw new Exception('Het winkelmandje heeft items nodig met een unieke ID waarde');
        if($this->checkItem($item)){
            foreach($this->items as $temp){
                if($temp->getId() == $item->getId() && $this->checkExtra($temp, $item)){                    
                    $temp->setAantal($temp->getAantal() + 1);
                }
            }
        }else{
            $item->setAantal(1);
            array_push($this->items, $item);
            array_push($this->ids, $item->getId());
        }
    }
    private function checkItem(Artikel $item){
        if(!(in_array($item->getId(), $this->ids))){return false;}
        return($this->checkExtras($item));
    }
    private function checkExtras(Artikel $item){        
        foreach($this->items as $temp){
            if($this->checkExtra($temp, $item)){
                return true;
            }  
        }        
        return false;
    }
    private function checkExtra(Artikel $temp, Artikel $item){
        if(!(count(array_filter($temp->getExtrasids())) == count(array_filter($item->getExtrasids())))){return false;}
        foreach($item->getExtrasids() as $extraid){
            if(!(in_array($extraid, $temp->getExtrasids()))){return false;}
        }
        return true;
    }   
    
    public function updateItem(Artikel $item, $aantal){ 
        foreach($this->items as $key => $temp){
            if($temp->getId() == $item->getId() && $this->checkExtra($temp, $item)){
                if($aantal==0){                     
                    unset($this->items[$key]);
                    unset($this->ids[$key]);
                }else{
                    $temp->setAantal($aantal);
                }
            }
        }             
    }
    public function deleteItem(Artikel $item){        
        $this->updateItem($item, 0);       
    }
    public function current() {
        $index = $this->ids[$this->positie];
        return $this->items[$index];

    }

    public function key() {
        return $this->positie;
    }

    public function next() {
        $this->positie++;
    }

    public function rewind() {
        $this->positie = 0;
    }

    public function valid() {
            return (isset($this->ids[$this->positie]));
    }

    public function count() {
            return count($this->items);
    }
    public function getTotaalPrijs(){
        $prijs = 0;
        foreach($this->items as $item){
            $prijs += ($item->getTotaalPrijs());
        }
        return $prijs;
    }
    public function getTotaalPrijsTekst(){
        return '€ '.$this->getTotaalPrijs();
    }
    public function getItems(){
        return $this->items;
    }  
    public function getAantalItems(){
        $aantal = 0;
        foreach($this->items as $item){
            $aantal += ($item->getAantal());
        }
        return $aantal;
    }
}
?>
