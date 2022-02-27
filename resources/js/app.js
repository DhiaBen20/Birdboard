import { createInertiaApp } from "@inertiajs/inertia-react";
import { render } from "react-dom";
import React from "react";
import Layout from "./layouts/Layout";

createInertiaApp({
    resolve: async (page) => {
        page = require(`./Pages/${page}`).default;

        page.layout = Layout;

        return page;
    },
    setup({ el, App, props }) {
        render(<App {...props} />, el);
    },
});
