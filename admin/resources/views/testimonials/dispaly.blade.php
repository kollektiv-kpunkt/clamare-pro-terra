<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    @vite(["resources/css/testimonial/style.scss"])
</head>
<body>

    <div class="cpt-testimonial-wrapper w-full aspect-square relative">
        <div alt="" class="absolute top-0 left-0 w-full h-full object-cover" style="background-size: 115%; background-position: center right; background-image: url({{"/uploads/images/i/" . $image}})">
        <div class="absolute top-0 left-0 w-full h-full object-cover" style="background-color: #ffffff; mix-blend-mode: saturation"></div>
        <div class="absolute top-0 left-0 w-full h-full object-cover" style="background-color: #8BDF89; mix-blend-mode: color; opacity: 0.5"></div>
        <img src="{{"/overlay.png"}}" alt="" class="absolute top-0 left-0 w-full h-full object-cover">
    </div>
</body>
</html>
