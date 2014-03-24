#!/usr/bin/php
<?php

	/**
	* Author: Samantha Cook-Chong
	* Date: 3/24/2014
	* Description: Simulates two people playing the card game war.
	*
	* Prints output to the terminal.
	*
	* Shuffles the deck before each game.
	* Deals 26 cards to each player.
	* Displays the cards that were played by each player for each 
	* turn, who was the winner, and the running score.
	* If one player runs out of cards they lose the round.
	*
	* Execution: 	Open a terminal and navigate to the location 
	* 				of the file War.php
	*
	*				At the command prompt type:
	*				php ./War.php
	*/

	class Card 
	{
		public $name;
  		public $number;   
    
		function __construct($aName,$aNumber)
    	{
			$this->name = $aName;
	    	$this->number = $aNumber;   
    	}
	}

	class Deck 
	{
		public $theDeck;
		public $numCards;
	
		function __construct()
		{
			$this->theDeck = array(
			new Card("2",2),new Card("2",2),
			new Card("2",2),new Card("2",2),
			new Card("3",3),new Card("3",3),
			new Card("3",3),new Card("3",3),
			new Card("4",4),new Card("4",4),
			new Card("4",4),new Card("4",4),
			new Card("5",5),new Card("5",5),
			new Card("5",5),new Card("5",5),
			new Card("6",6), new Card("6",6),
			new Card("6",6), new Card("6",6),
			new Card("7",7),new Card("7",7),
			new Card("7",7),new Card("7",7),
			new Card("8",8),new Card("8",8),
			new Card("8",8),new Card("8",8),
			new Card("9",9),new Card("9",9),
			new Card("9",9),new Card("9",9),
			new Card("T",10),new Card("T",10),
			new Card("T",10),new Card("T",10),
			new Card("J",11),new Card("J",11),
			new Card("J",11),new Card("J",11),
			new Card("Q",12),new Card("Q",12),
			new Card("Q",12),new Card("Q",12),
			new Card("K",13),new Card("K",13),
			new Card("K",13),new Card("K",13),
			new Card("A",14),new Card("A",14),
			new Card("A",14),new Card("A",14));
    
    	$this->numCards = count($this->theDeck);
		}

		public function Shuffle() 
		{
			shuffle($this->theDeck);
		}
	
		public function Deal($numPlayers) 
		{
			$size = ($this->numCards)/$numPlayers;
			return array_chunk($this->theDeck,$size);
		}
	}

	class Hand
	{
		public $cards;
		public $numCards;
	
		function __construct($c)
		{
			$this->cards = $c;
			$this->numCards = count($c);
		}		
	
		public function printHand()
		{
			$temp = $this->numCards;
		
			for($i=0; $i<$temp; $i++) 
			{
				echo $this->cards[$i]->name;
      			echo "	";	
			}	
			echo "\n";
		}
	
		public function addCards($wonThese)
		{
    		$this->numCards+=count($wonThese);
    		$this->cards = array_merge($this->cards,$wonThese);    
		}  
  
    public function emptyHand()
    {
      $this->cards = array();
      $this->numCards = 0;
    }
	}

	class Player
	{
		public $name;
		public $hand;
		public $cardsPlayed;  // cards the player has played in the current round
	
		public function playCards($number2play)
		{		
			  $retVal = array_splice($this->hand->cards,0,$number2play);
    		$this->cardsPlayed->cards = array_merge($this->cardsPlayed->cards,$retVal);
    		$this->cardsPlayed->numCards += $number2play;
			  $this->hand->numCards -= $number2play;
    		return $retVal;
		}
	
		function __construct($n,$h)
		{
			$this->name = $n;
			$this->hand = new Hand($h);
			$this->cardsPlayed = new Hand(array());	
		}	
	}

	function output($P1,$P2,$winner)
	{
		echo $P1->name." played:  ";
		$temp = $P1->cardsPlayed->numCards;

		for($i=0; $i<$temp; $i++) 
		{
			echo $P1->cardsPlayed->cards[$i]->name." ";	
		}
    echo "\n";

		echo $P2->name." played:  ";
		$temp2 = $P2->cardsPlayed->numCards;
  
		for($i=0; $i<$temp2; $i++) 
		{
			echo $P2->cardsPlayed->cards[$i]->name." ";	
		}		

		if($winner==0)
		{
			echo "\n".$P1->name." is the winner";
		}
		else if($winner==1)
		{
			echo "\n".$P2->name." is the winner";
		}
		else if($winner==2)
		{
			echo "\nIt was a tie";
		}
	
    echo "\nScore:  ";
    echo $P1->hand->numCards." to ";  
    echo $P2->hand->numCards;
		echo "\n\n";
	 
    $P1->cardsPlayed->emptyHand();
		$P2->cardsPlayed->emptyHand();  
	}

	function War($P1,$P2)
	{
		$numCardsP1 = $P1->hand->numCards;
		$numCardsP2 = $P2->hand->numCards;	
	
		// if one player is out of cards we have a winner
		//		add the cards the winner played and the cards the loser played to the winner's hand.
	
		if(($numCardsP1==0)&&($numCardsP2==0))
		{
      $P1->hand->addCards($P1->cardsPlayed->cards);
			$P2->hand->addCards($P2->cardsPlayed->cards);
			output($P1,$P2,2);
			return;
		}	
		else if($numCardsP1==0)
		{
      $P2->hand->addCards($P2->cardsPlayed->cards);
      $P2->hand->addCards($P1->cardsPlayed->cards);
			output($P1,$P2,1);
			return;
		}
		else if($numCardsP2==0)
		{
      $P1->hand->addCards($P1->cardsPlayed->cards);
			$P1->hand->addCards($P2->cardsPlayed->cards); 
			output($P1,$P2,0);	
			return;
		}	
	
		$C1 = $P1->playCards(1)[0]->number;
		$C2 = $P2->playCards(1)[0]->number;	
	
		// if the two players top cards are different we have a winner
		//		add the cards the winner played and the cards the loser played to the winner's hand.
	
		if($C1 > $C2)
		{
			$P1->hand->addCards($P1->cardsPlayed->cards);
			$P1->hand->addCards($P2->cardsPlayed->cards);
			output($P1,$P2,0);
			if(($P1->hand->numCards!=0)&&($P2->hand->numCards!=0))
			{
				War($P1,$P2);
			}
		}
		else if($C1 < $C2)
		{
      $P2->hand->addCards($P2->cardsPlayed->cards);
			$P2->hand->addCards($P1->cardsPlayed->cards);
			output($P1,$P2,1);

			if(($P1->hand->numCards!=0)&&($P2->hand->numCards!=0))
			{
				War($P1,$P2);
			}
		}	
	
		// if the two players top cards are the same we have a war
		//		go to war	
		else if ($C1 == $C2)
		{	
			TieBreaker($P1,$P2);

			if(($P1->hand->numCards!=0)&&($P2->hand->numCards!=0))
			{
				War($P1,$P2);
			}
		}
	}

	function TieBreaker($P1,$P2)
	{		
		$numCardsP1 = $P1->hand->numCards;
		$numCardsP2 = $P2->hand->numCards;	
	
		// if both of the players have less than 2 cards left then it is a tie
		if (($numCardsP1<2)&&($numCardsP2<2))
		{
			output($P1,$P2,2);
			return;
		}
	
		// if one of the two players has less than 2 cards the other player wins
	
		else if ($numCardsP1<2)
		{
      $P1->playCards($numCardsP1);
			$P2->playCards(2);  	
      $P2->hand->addCards($P2->cardsPlayed->cards);
      $P2->hand->addCards($P1->cardsPlayed->cards);
			output($P1,$P2,1);
			return;
		}
		else if ($numCardsP2<2)
		{
      $P1->playCards(2);
			$P2->playCards($numCardsP2);  		
      $P1->hand->addCards($P1->cardsPlayed->cards);
			$P1->hand->addCards($P2->cardsPlayed->cards);
			output($P1,$P2,0);
			return;
		}
	
		// if both the players have two or more cards their second cards are compared to see who the winner is.
		
		$C1 = $P1->playCards(2)[1]->number;
		$C2 = $P2->playCards(2)[1]->number;
		
		if($C1 > $C2)
		{
			$P1->hand->addCards($P1->cardsPlayed->cards);
			$P1->hand->addCards($P2->cardsPlayed->cards);
			output($P1,$P2,0);
			return;
		}
		else if($C1 < $C2)
  	{
    	$P2->hand->addCards($P2->cardsPlayed->cards);    
			$P2->hand->addCards($P1->cardsPlayed->cards);
			output($P1,$P2,1);
			return;
		}
		else if($C1 == $C2)
		{    
			TieBreaker($P1,$P2);
		}		
	}

	// main
	$aDeck = new Deck();
	$aDeck->Shuffle();

	$numPlayers = 2;
	$cardsDelt = $aDeck->Deal($numPlayers);

	$P1 = new Player("Joe",$cardsDelt[0]);
	$P2 = new Player("Sal",$cardsDelt[1]);

	echo $P1->name."'s Hand:\n";
	$P1->hand->printHand();
	echo "\n";

	echo $P2->name."'s Hand:\n";
	$P2->hand->printHand();
	echo "\n";

	War($P1,$P2);
?>
