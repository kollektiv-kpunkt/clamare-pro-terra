import { init, _, json, addMessages, locale } from "svelte-i18n";
import { page } from "$app/stores";

import de from "../lang/de.json";
import fr from "../lang/fr.json";
import it from "../lang/it.json";

addMessages("de", de);
addMessages("fr", fr);
addMessages("it", it);

let domains = {
    "localhost:5173": "it",
    "pn82.kpunkt.ch": "de",
    "fr.pn82.kpunkt.ch": "fr",
    "klima-demo.ch": "de",
    "manif-climat.ch": "fr",
    "www.manif-climat.ch": "fr",
    "manifestazione-clima.ch": "it",
    "www.manifestazione-clima.ch": "it"
}

export async function load(page) {
    let currentLocale = domains[page.url.host] || "de";

    init({
        initialLocale: currentLocale,
        fallbackLocale: "de",
    });
}