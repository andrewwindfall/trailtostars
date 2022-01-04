

<footer>
  <div class="row">
    <div class="four push_two columns centering">
      <img src="/assets/img/mrc-logo.svg" alt="">
    </div>
    <div class="four columns centering">
      <img src="/assets/img/semt-logo.svg" alt="">
    </div>
  </div>
  <div class="row">
    <div class="ten columns push_one">
      <p style="font-size:11px; color:#c3c3c3; text-align:center; font-style:italic; padding-top:10px;">© @php echo (date('Y')) @endphp Missouri River Country Montana. All Rights Reserved. <a href="/privacy-policy">Privacy Policy</a>. </p>
    </div>
  </div>



</footer>


@if(\Session::has('message'))
  <div class="message">
    {!! \Session::get('message') !!}
    <div class="ion-close"></div>
  </div>

  <script>
  function hide() {
    $('.message').removeClass('active');
  }
  setTimeout(hide, 4000);
  $('.message .ion-close').on('click', function(){
    $('.message').removeClass('active');
  });
  $('.message').addClass('active');
  </script>
@endif


@stack('footer')

</body>
</html>