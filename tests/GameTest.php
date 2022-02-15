<?php

use PHPUnit\Framework\TestCase;
// ALL FUNCTIONS ARE COMING FROM THE GAME FILE

// like an import
// We are testing the Game.php inside our src folder
require __DIR__ . "/../src/Entity/Game.php";
require __DIR__ . "/../src/Entity/Rating.php";
require __DIR__ . "/../src/Entity/User.php";

class GameTest extends TestCase {

   public function testImage_WithNull_ReturnsPlaceholder()  {
       $game = new Game();
       $game->setImagePath(null);
       $this->assertEquals('images/placeholder.png', $game->getImagePath());
   }

   // every test starts with the word test
   // We first need to create mocks before we begain the test

   // test the image with a path that is provided and to make sure it returns that path
   public function testImage_WithPath_ReturnsPath() {
        // instance of the game class
        $game = new Game();

        // checking the path is created 
        // setting the image path
        $game->setImagePath('images/game1.png');
        // checking to make sure the set path is equal to the asserted path. This is checking to make sure they are equal
        // getImagePath is from the setImagePath
        $this->assertEquals('images/game1.png', $game->getImagePath());
   }


   // checking the avergage scores without ratings. passing an empty array
   public function testAverageScore_WithoutRatings_ReturnsNull() {
        // instace of the game class
        $game = new Game();
        // setting ratings to an empty array
        $game->setRatings([]);

        // we are expecting a null 
        // we are testing that we get back a null
        $this->assertNull($game->getAverageScore());
   }


   // we want to return ratings that have 6 and 8 to return 7
   public function testAverageScore_With6And8_Returns7() {
        // creating two different mocks

        // creating an instance of class but all returns null
        $rating1 = $this->createMock(Rating::class);
        // making the method return 6
        $rating1->method('getScore')->willReturn(6);

        $rating2 = $this->createMock(Rating::class);
        $rating2->method('getScore')->willReturn(8);

        // testing for fail
        // testing a game to mock one method
        // allows us to keep all the methods and they keep all the functionality
        $game = $this->getMockBuilder(Game::class)
        ->setMethods(array('getRatings'))
        ->getMock();
        // php fluid mthod

        $game->method('getRatings')->willReturn([$rating1, $rating2]);

        // calling our assert method 
        // when the score is 7, it will get 6 and 8
        $this->assertEquals(7, $game->getAverageScore());
   }

   public function testAverageScore_WithNullAnd5_Returns5()
   {
       $rating1 = $this->createMock(Rating::class);
       $rating1->method('getScore')->willReturn(null);

       $rating2 = $this->createMock(Rating::class);
       $rating2->method('getScore')->willReturn(5);

       $game = $this->getMockBuilder(Game::class)
           ->setMethods(array('getRatings'))
           ->getMock();
       $game->method('getRatings')->willReturn([$rating1, $rating2]);

       $this->assertEquals(5, $game->getAverageScore());
   }

   // testing isRecommended from Game file
   public function testIsRecommended_WithCompatibility2AndScore10_ReturnsFalse()
   {
        // creating a rating and making it a mock
        $rating1 = $this->createMock(Rating::class);
        $rating1->method('getScore')->willReturn(10);
        // overriding a single method

        $user = $this->createMock(User::class);
        $user->method('getGenreCompatibility')->willReturn(2);

        // creating an instace of game and we dont want to wipe out the methods
        $game = $this->getMockBuilder(Game::class)
         ->setMethods(array('getRatings'))
         ->getMock();
        $game->method('getRatings')->willReturn([$rating1]);

        // making it return false
        $this->assertFalse($game->isRecommended($user));

   }

   public function testIsRecommended_WithCompatibility10AndScore10_ReturnsTrue()
   {
        // creating a rating and making it a mock
        $rating1 = $this->createMock(Rating::class);
        $rating1->method('getScore')->willReturn(10);
        // overriding a single method

        $user = $this->createMock(User::class);
        $user->method('getGenreCompatibility')->willReturn(10);

        // creating an instace of game and we dont want to wipe out the methods
        $game = $this->getMockBuilder(Game::class)
         ->setMethods(array('getRatings'))
         ->getMock();
        $game->method('getRatings')->willReturn([$rating1]);

        // making it return false
        $this->assertTrue($game->isRecommended($user));
   }
}
