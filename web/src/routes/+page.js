import { init, _, json, addMessages, locale } from "svelte-i18n";

import de from "../lang/de.json";
import fr from "../lang/fr.json";
import { onMount } from "svelte";

addMessages("de", de);
addMessages("fr", fr);

init({
    initialLocale: "de",
});