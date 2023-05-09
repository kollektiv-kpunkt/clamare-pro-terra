import "./loader.scss";

export function createLoader() {
    let loader = document.createElement("div");
    loader.classList.add("cpt-form-loader");
    loader.innerHTML = `
    <div class="lds-default"><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div></div>
    `;
    document.body.appendChild(loader);
    setTimeout(() => {
        loader.style.opacity = 1;
    }, 100);
    return loader;
}

export function removeLoader(loader) {
    loader.style.opacity = 0;
    setTimeout(() => {
        loader.remove();
    }, 500);
}