@extends('layouts.homepage')
@section('content')
<div id="flashcard">
  <div class="play" v-if="isPlay">
    <div class="text">
        <a href="/games/">
            <img src="/images/icon.png" class="icon-img">
        </a>
        <img src="/images/English.png" class="img-en">
        <img src="/images/home.png" class="img-green">
    </div>
    <div class="basic">
        <p class="cards">@{{ index }}/@{{ this.flashcards ? this.flashcards.length : '' }}</p>
        <p class="score">Score: @{{ score }}</p>
        <p id="demo" class="display-4 time"></p>
        <img src="/images/Line 1.png">
    </div>
    <div v-if="currentFlashcard">
      <div class="word">
          <span>@{{currentFlashcard.word}}</span>
      </div>
      <div>
          <div class="img-card">
              <img :src="'/images/'+ currentFlashcard.upload_path" class="img-thumbnail style-img"/>
          </div>
          <div class="button-answer">
              <p v-for="(answer, index) in currentFlashcard.answer_options" :key="index" class="answer-size">
                    <input type="radio" @click="checkAnswer($event, currentFlashcard.id, answer.id)" 
                           name="gender" 
                           :value="answer.id" 
                           class="answer"
                    />@{{answer.value}}
              </p>
              <div>
                  <button v-if="!finish && showNext" class="btn btn-danger" 
                  @click="nextQuestion(index)">Next
                  </button>
                  <button v-if="finish" class="btn btn-danger" 
                  @click="finished" disabled id="finish">Finish
                  </button>
              </div>
          </div>
      </div>
    </div>
    <div>
        <img src="/images/home.png" class="img-footer">
    </div>
  </div>
  <div v-else class="a">
  <div class="text">
        <img src="/images/blue.png" class="img-green">
    </div>
    <div style="with:10%; margin-left: 50px; padding-top:10px">
        <img src="/images/picture.png">
    </div>
    <div class="all">
        <div class="backgroud">
            <div style="margin-left: 10%;">
                <img src="/images/finish.png"/> 
                <h2 style="float:right">Congratulations<br/>
                <p>Your Score: @{{score}}</p>
            </h2>  
            </div>
        </div>
    </div>
    <div style="padding-top: 9%;">
        <img src="/images/blue.png" class="img-footer">
    </div>
    <div style="with:10%; margin-right: 70px; padding-top:30px; float:right">
        <img src="/images/picture.png">
    </div>
  </div>
</div>

<script type="application/javascript">
    var app = new Vue({
    el: '#flashcard',
    data () {
      return {
        flashcards: null,
        currentFlashcard: null,
        index: 1,
        score: 0,
        finish: false,
        showNext: false,
        answer: null, 
        isPlay: true,
        gameId: null
      }
    },
    created() {
      //split url to get game id
      this.gameId = window.location.pathname.split('/')[2]
      axios.get('/games/get_flashcard/{{$id}}')
      .then(response => {
        this.flashcards = response.data
        this.currentFlashcard = this.flashcards[0]
      })
    },
    
    methods: {
      nextQuestion (index) {
        this.currentFlashcard = this.flashcards[index]
        this.showNext = false
        var ans = document.getElementsByClassName('answer')
        for (var i = ans.length - 1; i >= 0; i--)
        {
          //remove class `right` has been add before when move to next flashcard
          if (ans[i].parentNode.classList.contains('right')) ans[i].parentNode.classList.remove('right')
          //reset radio button
          ans[i].checked = false
        }
        for (var i = ans.length - 1; i >= 0; i--)
        {
          //remove class `flase` has been add before when move to next flashcard
          if (ans[i].parentNode.classList.contains('false')) ans[i].parentNode.classList.remove('false')
          //reset radio button
          ans[i].checked = false
        }
        //enable answers
        var radio = document.getElementsByClassName('answer')
        for (var i = radio.length - 1; i >= 0; i--)
        {
          radio[i].disabled = false
        }
        if (index == this.flashcards.length -1) {
          this.finish = true
          this.index = index + 1
          return
        } else {
          this.index = index + 1
        }
      },
      finished () {
        let params = {
          game_id:  this.gameId,
          score: this.score
        }
        axios.post('/games/submit_score', params)
        .then(response => {
          this.isPlay = false
        })
      },
      checkAnswer (event, flashcardId, answerId) {
        //remove class `right` has been add before
        var el = document.getElementsByClassName("right")
        for (var i = el.length - 1; i >= 0; i--)
        {
          el[i].classList.remove('right')
        }
       
        let params = {
          answer_id: answerId,
          flashcard_id: flashcardId
        }
        
        axios.post('/games/check', params)
          .then(response => {
            if (response.data == 'true') {
              event.target.parentNode.classList.add('right')
              this.score = this.score + 1;
            }else{
              event.target.parentNode.classList.add('false')
            }
          })
        //disable answer
        var radio = document.getElementsByClassName('answer')
        for (var i = radio.length - 1; i >= 0; i--)
        {
          radio[i].disabled = true
        }
        this.showNext = true
        let btn = document.getElementById("finish");
        if (btn) btn.disabled = false;
      }
    }
  })
</script>

<script>
  // Set the date we're counting down to
  var countDownDate = new Date().getTime();
  // Update the count down every 1 second
  var x = setInterval(function () {
      // Get today's date and time
      var now = new Date().getTime();
      // Find the distance between now and the count down date
      var distance = now - countDownDate;
      // Time calculations for days, hours, minutes and seconds
      var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
      var seconds = Math.floor((distance % (1000 * 60)) / 1000);
      // Output the result in an element with id="demo"
      document.getElementById("demo").innerHTML = "  " + minutes + " : " + seconds + "";
      // If the count down is over, write some text
      if (distance < 0) {
          clearInterval(x);
          document.getElementById("demo").innerHTML = "EXPIRED";
      }
  }, 1000);
</script>
<style>
  .right {
    color: darkgreen;
  }
  .false{
    color: red;
  }
</style>
@endsection

