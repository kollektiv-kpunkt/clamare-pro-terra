import { json, fail, redirect } from '@sveltejs/kit';
import fs from 'fs';
import { _ } from "svelte-i18n";

export function GET() {
    let pics = [];
    let files = fs.readdirSync('./static/images/demopictures');
    files.forEach(file => {
        pics.push("/images/demopictures/" + file);
    });
    pics.sort(() => Math.random() - 0.5);
    return json({ pics });
}