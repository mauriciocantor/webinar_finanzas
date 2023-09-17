// var boo_audio = document.createElement("audio");
// boo_audio.setAttribute("src", "sounds/boo.mp3");
//
// var applause_audio = document.createElement("audio");
// applause_audio.setAttribute("src", "sounds/applause.mp3");
//
// var blop_audio = document.createElement("audio");
// blop_audio.setAttribute("src", "sounds/blop.mp3");
var winOrLose = false;
let foundLetters = localStorage.getItem('foundLetters');
let word = localStorage.getItem('words');
let foundWord = new Array(word.length);

$(".letter").click(function(){

	let letter = $(this).text();


	let response = [];

	letter = letter.toLowerCase();
	let wordLetters = word.split('');
	let guessedWord = '';
	//foundLetters = foundLetters.split('');
	if(!winOrLose)
	{
		if(word.toLowerCase().indexOf(letter) !== -1)
		{
			for (let i = 0; i < wordLetters.length; i++) {
				console.log(foundWord[i]);
				if(
					wordLetters[i]===letter &&
					(typeof foundWord[i] == 'undefined' || foundWord[i].indexOf('guessed-letter') > -1)
				){
					foundWord[i]=letter;
				}else if((typeof foundWord[i] == 'undefined' || foundWord[i].indexOf('guessed-letter') > -1)){
					foundWord[i]='<span class="guessed-letter">_</span>';
				}
			}
			let filterWord = foundWord.filter((word)=>{
				return (word.indexOf('guessed-letter') > -1);
			});

			if(filterWord.length === 0){
				winOrLose=true;
			}

		}else{
			live--;
			imagen++;

			$('#hangman').attr('src','/images/hangman/' + imagen + '.jpg');
			$('#lives-left').text(live);
			if(live === 0)
			{
				winOrLose = false;
				foundWord = ['La palabra era: <b>' + word + '</b>'];
			}else{
				for (let i = 0; i < wordLetters.length; i++) {
					if ((typeof foundWord[i] == 'undefined' || foundWord[i].indexOf('guessed-letter') > -1)) {
						foundWord[i] = '<span class="guessed-letter">_</span>';
					}
				}
			}
		}
		$(this).addClass("display-none");
	}

	/*for (const wordLetter of wordLetters) {
		let found = false;

		for (const foundLetter of foundLetters) {
			if(foundLetter.toLowerCase() === wordLetter.toLowerCase()){
				found=true;
				break;
			}
		}

		if(found) {
			guessedWord = guessedWord.concat(letter);
			console.log(guessedWord);
			//guessedWord = guessedWord.join();
		}else if(letter != ' ') {
			guessedWord += '<span class="guessed-letter">_</span>';
		}else {
			guessedWord += ' ';
		}
	}*/

	guessedWord = foundWord.join("");
	response['win'] = winOrLose;
	//response['lives'] = $_SESSION['lives'];
	response['guessedWord'] = guessedWord;
	$('#guessed-word-div').html(guessedWord);

}); 
