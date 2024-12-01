// Get the language selector and the element to display translated text
const languageSelect = document.getElementById('language');
const elementsToTranslate = document.querySelectorAll('[data-translate]');

const translateText = async (targetLanguage) => {
    const apiKey = 'AIzaSyDy33O2S9n9F2WVGC3yJBQOwRNfRUQd1ok';
    
    elementsToTranslate.forEach(async (element) => {
        const textToTranslate = element.getAttribute('data-translate');
        const url = `https://translation.googleapis.com/language/translate/v2?key=${apiKey}`;

        try {
            const response = await fetch(url, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({
                    q: textToTranslate,
                    target: targetLanguage,
                }),
            });

            if (!response.ok) {
                throw new Error(`Error: ${response.statusText}`);
            }

            const data = await response.json();
            const translatedText = data.data.translations[0].translatedText;

            // Update the element's content or attribute based on its type
            if (element.tagName === 'INPUT' && element.hasAttribute('placeholder')) {
                element.setAttribute('placeholder', translatedText);
            } else {
                element.innerText = translatedText;
            }
        } catch (error) {
            console.error('Translation failed:', error);

            if (element.tagName === 'INPUT' && element.hasAttribute('placeholder')) {
                element.setAttribute('placeholder', 'Translation failed');
            } else {
                element.innerText = 'Translation failed';
            }
        }
    });
};

// Add event listener to the language select element
languageSelect.addEventListener('change', (event) => {
    const selectedLanguage = event.target.value;
    translateText(selectedLanguage);
});

// Initial load
translateText(languageSelect.value);


