import js from "@eslint/js"
import globals from "globals"
import { defineConfig } from "eslint/config"

export default defineConfig([
  {
    files: ["**/*.{js,mjs,cjs}"],
    plugins: { js },
    extends: ["js/recommended"],
    languageOptions: {
      globals: {
        ...globals.browser,
        isConnected: "writable",
        getRole: "writable",
        showAndHideElementsForRoles: "writable",
        apiUrl: "writable",
        sanitizeHtml: "writable",
        getInfosUser: "writable",
        loaderPage: "writable",
        getToken: "writable"
      }
    },
    rules: {
      "no-unused-vars": ["error", "never"],// no error on unused variables
      "no-undef": "error",                 // Error on use of undeclared variables
      "curly": "error",                    // Require curly braces for all control statements
      "no-empty": "warn",                  // Warn on empty code blocks
      "no-unreachable": "error",           // Error on unreachable code after return, throw, etc.
      "quotes": ["error", "double"],       // Enforce double quotes
      "semi": ["error", "never"],          // To avoid the semicolons
      "no-var": "error",                   // Disallow var, use let/const instead
      "prefer-const": "warn",              // Suggest using const
      "no-multiple-empty-lines": ["warn", { "max": 1 }],
      "comma-dangle": ["error", "never"],  // No trailing commas
      "brace-style": ["error", "1tbs"],    // Enforce one true brace style
      "space-before-blocks": ["error", "always"]
    }
  }
])