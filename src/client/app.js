import { mount } from 'svelte'
import './app.css'
import App from './App.svelte'

const app = mount(App, {
  // @ts-ignore
  target: document.getElementById('app'),
})

export default app
