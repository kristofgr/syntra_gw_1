import { createLogger, defineConfig } from "vite";

const logger = createLogger();

logger.warnOnce = (msg, options) => {
  // Negeer waarschuwing betreffende icons.ttf
  if (msg.includes("icons.ttf referenced")) return;
  console.log(msg);
};

export default defineConfig({
  customLogger: logger,
  build: {
    //de volgende instelling genereert een manifest bestand waar alle gebuilde files in zitten.
    //we moeten tenslotte hun unieke filename kennen om ze te kunnen koppelen met de php file.
    //de reden dat de gegenereerde files telkens andere filenames hebben geeft 1 groot voordeel.
    //een bestand met een nieuwe naam wordt altijd gedownload en is dus nooit gecached.
    manifest: true,
    //de watch instelling zorgt ervoor dat de build altijd opnieuw wordt uitgevoerd als de scss od js file wijzigt
    watch: true,
    //onderstaande stelt de js file in als entrypoint voor vite ipv. index.html (+ die van /admin)
    rollupOptions: {
      input: ["/js/index.js", "/admin/js/index.js"],
    },
    // plaats de gebundelde css en js files in de dist folder en niet in een /assets
    // zo kunnen we correct verwijzen naar bijvoorbeeld files zoals icons.ttf
    assetsDir: "",
  },
});
