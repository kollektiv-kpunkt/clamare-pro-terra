import { json, fail, redirect } from '@sveltejs/kit';
import fs from 'fs';
import captureWebsite from 'capture-website';

export function GET() {
    let pics = [];
    let files = fs.readdirSync('./static/images/demopictures');
    files.forEach(file => {
        pics.push("/images/demopictures/" + file);
    });
    pics.sort(() => Math.random() - 0.5);
    return json({ pics });
}

export const POST = (async ({ request, url }) => {
    try {
        const data = Object.fromEntries(await request.formData())
        const upload = data.image;
        const filename = crypto.randomUUID() + upload.name;
        const filePath = './static/images/profilepictures/' + filename;
        let buffer = Buffer.from(await (upload).arrayBuffer());
        await fs.writeFileSync(filePath, buffer);
        const profilePictureName = '/images/profilepictures/' + crypto.randomUUID() + '.png';
        let requestUrl = new URL(request.url);
        let url = requestUrl.protocol + "//" + requestUrl.host + "/pfp?img=" + filename;
        await captureWebsite.file(url, './static' + profilePictureName, {
            width: 1080,
            height: 1080,
            scaleFactor: 1,
        });
        return json({
            url: profilePictureName
        })
    } catch (err) {
        throw fail(500, { err: err })
    }
})