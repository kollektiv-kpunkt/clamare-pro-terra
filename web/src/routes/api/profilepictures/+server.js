import { json, fail, redirect } from '@sveltejs/kit';
import fs from 'fs';
import { _ } from "svelte-i18n";

export function GET(request) {
    let locale = request.url.searchParams.get('locale');
    let pics = [];
    let files = fs.readdirSync('./static/images/demopictures/' + locale);
    files.forEach(file => {
        pics.push("/images/demopictures/" + locale + "/" + file);
    });
    pics.sort(() => Math.random() - 0.5);
    return json({ pics });
}