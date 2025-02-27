declare module 'oh-vue-icons' {
  import { DefineComponent } from 'vue'
  const OhVueIcon: DefineComponent<{}, {}, any>
  function addIcons(...icons: any[]): void
  export { OhVueIcon, addIcons }
}

declare module 'oh-vue-icons/icons' {
  const icons: { [key: string]: any }
  export = icons
}
