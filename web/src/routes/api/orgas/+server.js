import { json } from '@sveltejs/kit';
import fs from 'fs';

export function GET() {
    let orgas = [];
    let files = fs.readdirSync('./static/images/orgas');
    files.forEach(file => {
        orgas.push("/images/orgas/" + file);
    });
    orgas.sort(() => Math.random() - 0.5);
    return json({ orgas });
}
