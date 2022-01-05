<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>@if(isset($metatitle)) {{$metatitle}} | @endif Trail to the Stars</title>

		    <link href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css" rel="stylesheet" type="text/css">
        <link href="/css/app.css" rel="stylesheet" type="text/css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>

        <!-- basic tags -->
        <meta name="description" content="@if(isset($metadesc)) {{$metadesc}} @else Montana Trail to the stars, our Astrotourism, Stargazing, and tourism information website. @endif" />
        <meta name="keywords" content="@if(isset($page->keywords)) {{$page->keywords}} @endif ,Trail to the stars, Astrotourism, Stargazing, montana, missouri river country, southeast Montana" />

        <!-- Facebook Metadata /-->
      	<meta property="fb:page_id" content="" />
      	<meta property="og:image" content=@if(isset($ogImage)) {{ $ogImage }} @else "http://trailtothestars.com/assets/img/home.jpg" @endif />
      	<meta property="og:description" content="@if(isset($metadesc)) {{$metadesc}} @else Montana Trail to the stars, our Astrotourism, Stargazing, and tourism information website.  @endif" />
      	<meta property="og:title" content="@if(isset($metatitle)) {{$metatitle}} | @endif Trail to the Stars"/>

      	<!-- Google+ Metadata /-->
      	<meta itemprop="name" content="@if(isset($metatitle)) {{$metatitle}} | @endif Trail to the Stars">
      	<meta itemprop="description" content="@if(isset($metadesc)) {{$metadesc}} @else Montana Trail to the stars, our Astrotourism, Stargazing, and tourism information website. @endif">
      	<meta itemprop="image" content=@if(isset($ogImage)) {{ $ogImage }} @else "http://trailtothestars.com/assets/img/home.jpg" @endif>

        <script src="https://cdn.jsdelivr.net/gh/alpinejs/alpine@v2.x.x/dist/alpine.min.js" defer></script>

        @stack('header')

    </head>
    <body>

    	<header>
        <a href="/">
      		<div class="logo">
      			<!-- insert logo here -->
      		</div>
        </a>

        <div id="dropdownmenu"></div>

    		<div class="navigation">

					<span>Montana's Trail to the Stars</span>

					<ul id="menu">
            @include('partials.nav')
					</ul>

    		</div>

    	</header>
