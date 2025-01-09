const { defineConfig } = require("cypress");

module.exports = defineConfig({
  e2e: {
    baseUrl: "http://localhost:8000", // URL base do seu projeto
    setupNodeEvents(on, config) {
      // Implementar event listeners aqui, se necessário
    },
    specPattern: "cypress/integration/**/*.spec.js", // Local dos arquivos de teste
     chromeWebSecurity: false,
  },
});
