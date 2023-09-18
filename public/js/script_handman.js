var winOrLose = false;
let foundLetters = localStorage.getItem('foundLetters');
let wordHangman = localStorage.getItem('words');
let foundWord = new Array(wordHangman.length);

$(".letter").click(function(){

	let letter = $(this).text();


	let response = [];

	letter = letter.toLowerCase();
	let wordLetters = wordHangman.split('');
	let guessedWord = '';
	//foundLetters = foundLetters.split('');
	if(!winOrLose)
	{
		if(wordHangman.toLowerCase().indexOf(letter) !== -1)
		{
			for (let i = 0; i < wordLetters.length; i++) {
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
				$('#result_finish-hangman').css('display','block');
				$.post({
					'url':urlHangman,
					'data': {result:true, text:wordHangman}
				});
			}

		}else{
			live--;
			imagen++;

			$('#hangman').attr('src','/images/hangman/' + imagen + '.jpg');
			$('#lives-left').text(live);
			if(live === 0)
			{
				winOrLose = false;
				foundWord = ['La palabra era: <b>' + wordHangman + '</b>'];
				$('#result_finish-hangman').css('display','block');
				$.post({
					'url':urlHangman,
					'data': {result:false, text:wordHangman}
				});

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

	guessedWord = foundWord.join("");
	response['win'] = winOrLose;
	//response['lives'] = $_SESSION['lives'];
	response['guessedWord'] = guessedWord;
	$('#guessed-word-div').html(guessedWord);


}); 
