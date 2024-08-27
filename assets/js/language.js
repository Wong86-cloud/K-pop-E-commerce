// Get the language selector and the element to display translated text
const languageSelect = document.getElementById('language');
const translatedTextElement = document.getElementById('translated-text'); // Assume this element exists

const translateText = async (targetLanguage) => {
    const apiKey = 'AIzaSyCk4m2zzX_MzmK3j53ITjrgAifMsLPohs0';
    const textToTranslate = 'Hello, world!'; // Example text to translate
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
        translatedTextElement.innerText = `Translated Text: ${translatedText}`;
    } catch (error) {
        console.error('Translation failed:', error);
        translatedTextElement.innerText = 'Translation failed. Please try again later.';
    }
};

// Add event listener to the language select element
languageSelect.addEventListener('change', (event) => {
    const selectedLanguage = event.target.value;
    translateText(selectedLanguage);
});

// Initial load
translateText(languageSelect.value);


// Initial load
translateText(languageSelect.value);




