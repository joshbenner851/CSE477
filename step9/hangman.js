/**
 * Created by joshbenner on 4/2/16.
 */
function randomWord() {
    var words = ["moon","home","mega","blue","send","frog","book","hair","late",
        "club","bold","lion","sand","pong","army","baby","baby","bank","bird","bomb","book",
        "boss","bowl","cave","desk","drum","dung","ears","eyes","film","fire","foot","fork",
        "game","gate","girl","hose","junk","maze","meat","milk","mist","nail","navy","ring",
        "rock","roof","room","rope","salt","ship","shop","star","worm","zone","cloud",
        "water","chair","cords","final","uncle","tight","hydro","evily","gamer","juice",
        "table","media","world","magic","crust","toast","adult","album","apple",
        "bible","bible","brain","chair","chief","child","clock","clown","comet","cycle",
        "dress","drill","drink","earth","fruit","horse","knife","mouth","onion","pants",
        "plane","radar","rifle","robot","shoes","slave","snail","solid","spice","spoon",
        "sword","table","teeth","tiger","torch","train","water","woman","money","zebra",
        "pencil","school","hammer","window","banana","softly","bottle","tomato","prison",
        "loudly","guitar","soccer","racket","flying","smooth","purple","hunter","forest",
        "banana","bottle","bridge","button","carpet","carrot","chisel","church","church",
        "circle","circus","circus","coffee","eraser","family","finger","flower","fungus",
        "garden","gloves","grapes","guitar","hammer","insect","liquid","magnet","meteor",
        "needle","pebble","pepper","pillow","planet","pocket","potato","prison","record",
        "rocket","saddle","school","shower","sphere","spiral","square","toilet","tongue",
        "tunnel","vacuum","weapon","window","sausage","blubber","network","walking","musical",
        "penguin","teacher","website","awesome","attatch","zooming","falling","moniter",
        "captain","bonding","shaving","desktop","flipper","monster","comment","element",
        "airport","balloon","bathtub","compass","crystal","diamond","feather","freeway",
        "highway","kitchen","library","monster","perfume","printer","pyramid","rainbow",
        "stomach","torpedo","vampire","vulture"];
    return words[Math.floor(Math.random() * words.length)];
}

function generateHTML(word){
    var html = "<img id='harold' src='hangman/hm0.png' height='300' width='125' alt='harold being hanged'><p id='guess'>" + createWord(word);
    html += "</p><form>" + "<input type='hidden' id='word' value='" + word + "'>";
    html += "</p>" + "<label for='letter'>Letter:</label>"
    + "<input id='letter' type='text' name='letter'>";
    html += "<p><input id='guessBtn' type='submit' value='Guess!'>"
    + "<input type='submit' id='newgame' value='New Game'></p>"
        + "<p id='message'>&nbsp;</p></form>";
    return html;
}

function createWord(word){
    var html = "";
    for(var i=0;i<word.length;i++){
        html += "_ ";
    }
    html += "";

    return html;
}

function hangman() {
    var genWord = randomWord();
    console.log(genWord);
    var maxGuesses = 6;
    var numGuesses = 0;
    var playArea = document.getElementById("play-area");
    playArea.innerHTML = generateHTML(genWord);

    var img = "hangman/hm0.png";
    var harold = document.getElementById("harold");
    var guessBtn = document.getElementById("guessBtn"); //< Guess btn
    var newgameBtn = document.getElementById("newgame"); //< New Game btn
    var message = document.getElementById("message");
    var word = document.getElementById("guess");

    newgameBtn.onclick = function(event){
        var hiddenWord = document.getElementById("word");
        event.preventDefault();
        numGuesses = 0;
        genWord = randomWord();
        console.log("new word: " , genWord);
        word.innerHTML = createWord(genWord);
        hiddenWord.value = genWord;
    }
    guessBtn.onclick = function (event) {
        event.preventDefault();
        var letter = document.getElementById("letter"); //< letter they guesses

        // Only grab 1st character
        letter = letter.value.charAt(0);
        // Check that it's actually a letter
        if (!isLetter(letter)) {
            message.innerHTML = "You must enter a letter!";
            letter.value = "";
        }
        else {
            // Check if the letter is in the word
            if (genWord.indexOf(letter) == -1) {
                //console.log("you wrongly guessed: " , letter);
                numGuesses += 1;
                if(numGuesses >= maxGuesses){
                    message.innerHTML = "You guessed poorly!";
                    harold.src = "hangman/hm6.png";
                    var str = "";
                    for(var i=0;i<genWord.length;i++){
                        str += genWord[i] + " ";
                    }
                    //console.log("word expanded", str);
                    word.innerHTML = str;
                }
                else{
                    letter.value = "";
                    var imgSub = img.substr(0, 10);
                    harold.src = imgSub + numGuesses + img.substr(11, img.length);
                }
            }
            else {
                var partialWord = "";
                for (var i = 0; i < genWord.length; i++) {
                    if (genWord[i] == letter) {
                        partialWord += letter + " ";
                    }
                    else if(word.innerHTML.indexOf(genWord[i]) != -1){
                        partialWord += genWord[i] + " ";
                    }
                    else {
                        partialWord += "_ ";
                    }
                }
                //console.log("you correctly guessed: ", letter);
                word.innerHTML = partialWord;
                partialWord = partialWord.replace(/ /g, "");
                if(partialWord == genWord){
                    message.innerHTML = "You Win!"

                }
            }

        }
    }
}

// Taken from stackoverflow
// http://stackoverflow.com/questions/9862761/how-to-check-if-character-is-a-letter-in-javascript
// Credit to Jared Par
// Work smarter not harder
function isLetter(str) {
  return str.length === 1 && str.match(/[a-z]/i);
}