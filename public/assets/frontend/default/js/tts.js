/**
 * Reusable Text-to-Speech (TTS) service using the browser's Web Speech API.
 */
const studaiTtsService = {
    // Property to hold the SpeechSynthesisUtterance instance
    utterance: null,

    /**
     * Checks if the browser supports the Speech Synthesis API.
     * @returns {boolean}
     */
    isSupported: function() {
        return 'speechSynthesis' in window;
    },

    /**
     * Speaks the provided text.
     * If speech is already in progress, it cancels the old one and starts the new one.
     * @param {string} text - The text to be spoken.
     */
    speak: function(text) {
        if (!this.isSupported()) {
            console.error("Browser does not support Speech Synthesis.");
            alert("Sorry, your browser does not support the voice feature.");
            return;
        }

        // If speaking, cancel first to avoid overlap
        if (window.speechSynthesis.speaking) {
            window.speechSynthesis.cancel();
        }

        this.utterance = new SpeechSynthesisUtterance(text);

        // Optional: Configure voice, pitch, rate
        // let voices = window.speechSynthesis.getVoices();
        // this.utterance.voice = voices[0]; // Choose a specific voice
        this.utterance.pitch = 1; // 0 to 2
        this.utterance.rate = 1; // 0.1 to 10
        this.utterance.volume = 1; // 0 to 1

        window.speechSynthesis.speak(this.utterance);
    },

    /**
     * Cancels any ongoing speech.
     */
    cancel: function() {
        if (this.isSupported() && window.speechSynthesis.speaking) {
            window.speechSynthesis.cancel();
        }
    }
};
