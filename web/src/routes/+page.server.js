import * as fs from 'fs';

export function load({ params }) {
    let now = new Date().toISOString();
    let filename = `test-${now}.txt`;
    let filepath = `./data/${filename}`;
    let content = `This is a test file created at ${now}`;
    fs.writeFile(filepath, content, (err) => {
        if (err) throw err;
        console.log(`File ${filename} saved.`);
    });
}