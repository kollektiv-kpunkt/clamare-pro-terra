<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Hoi Lena!</title>
    @vite(["resources/css/app.scss"])
</head>
<body>

    <form action="/api/testimonial/upload" class="flex flex-col max-w-md mx-auto px-5 mt-12 md:mt-20 gap-y-12" method="POST" enctype="multipart/form-data">
        <h1 class="text-2xl">Lade hier ein Bild von dir hoch, Lena!</h1>
        <div>
            <input type="file" name="image">
        </div>
        <button type="submit" class="bg-rose-100 p-4">Testimonial generieren</button>
    </form>

</body>
</html>
