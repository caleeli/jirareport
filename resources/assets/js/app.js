
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

Vue.component('example', require('./components/Example.vue'));
const app = new Vue({
    el: '#app',
    data: function () {
        return {
            seguimientos: [],
        };
    },
    methods: {
        colchon: function (issue) {
            return Math.max(issue.estimateTime + 0*3600 - issue.spentTime, 0);
        },
        crTime: function () {
            return 1.5*3600;
        },
        ftTime: function () {
            return 6*3600;
        },
        total: function (issue) {
            return issue.estimateTime/* + this.colchon(issue)*/ + this.crTime() + this.ftTime();
        },
        estado: function (status) {
            return ['Open','Ready for Dev','Pending PM Input', 'Code Review', 'QA Sign-Off', 'Merge Sign-Off', 'Resolved'].indexOf(status);
        },
        avance: function (issue) {
            return this.estado(issue.status);
        },
        totalSpent: function (assignee) {
            var self = this;
            var total = 0;
            assignee.issues.forEach(function(issue) {
                total+=issue.spentTime;
            });
            return total;
        },
        totalColchon: function (assignee) {
            var self = this;
            var total = 0;
            assignee.issues.forEach(function(issue) {
                total+=self.colchon(issue);
            });
            return total;
        },
        totalRemaining: function (assignee) {
            var self = this;
            var total = 0;
            assignee.issues.forEach(function(issue) {
                total+=issue.remainingTime;
            });
            return total;
        },
    },
    mounted: function () {
        var self = this;
        $.ajax({
            'url': '/api/list',
            'success': function (res) {
                self.seguimientos.splice(0);
                res.forEach(function (seg) {
                    self.seguimientos.push(seg);
                });
            }
        });
    }
});
