/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

//window.Vue = require('vue');
import Vue from 'vue'

import draggable from 'vuedraggable'//draggableコンポーネントの読み込み

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))

Vue.component('example-component', require('./components/ExampleComponent.vue').default);

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

const app = new Vue({
    el: '#app',
    data:{
        name:"Tom"
    }
});

//draggableに使用する
const appDraggable = new Vue({
  el: "#appDraggable",
  components: {
    'draggable': draggable,
  },
  methods: {
        onstart: (e) => {
          console.log("onstart")
        },
        onadd: (e) => {
          console.log("onadd")
        },
        onremove: (e) => {
          console.log("onremove")
        },
        onupdate: (e) => {
          console.log("onupdate")
        },
        onend: (e) => {
          console.log("onend")
          //ここにnew_order_indexを順番通りにするコードを書く。
          //対象としているテーブルの要素
        },
        onchoose: (e) => {
          console.log("onchoose")
        },
        onsort: (e) => {
          console.log("onsort")
        },
        onfilter: (e) => {
          console.log("onfilter")
        },
        onclone: (e) => {
          console.log("onclone")
        },
        onmove: (e) => {
          console.log("onmove")
          return true
        }
      }
});