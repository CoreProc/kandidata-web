'use strict';

angular.module('kandidata')
    .controller('CandidateController', [
        '$rootScope',
        '$scope',
        '$stateParams',
        '$state',
        'session',
        'api',
        function ($rootScope, $scope, $stateParams, $state, session, api) {
            var vm = this;

            vm.isReady = false;
            vm.candidates = ['binay', 'santiago', 'duterte', 'poe', 'roxas'];
            vm.candidate = session.getCandidates();

            vm.sentiments = null;
            vm.feels = {"anger":0.14,"joy":0.39,"disgust":0.08,"fear":0.17,"sadness":0.22};
            vm.keywords = [{"count":18,"name":"parin","relevance":0.962538},{"count":18,"name":"https:\/\/t.co\/eRWKao5T7M","relevance":0.314673},{"count":17,"name":"Congressman       https:\/\/t.\u2026","relevance":0.978606},{"count":17,"name":"VS","relevance":0.740229},{"count":13,"name":"intelligent voter","relevance":0.981623},{"count":13,"name":"Miriam.","relevance":0.677086},{"count":8,"name":"President","relevance":0.416507},{"count":6,"name":"campaign","relevance":0.969688},{"count":5,"name":"vote","relevance":0.776717},{"count":4,"name":"victim","relevance":0.991161},{"count":4,"name":"Madam","relevance":0.94668},{"count":4,"name":"FILIPINO","relevance":0.901384},{"count":4,"name":"leader","relevance":0.887102},{"count":4,"name":"Polls","relevance":0.867309},{"count":4,"name":"https:\/\/t.co\/MBp4wYX7EV","relevance":0.844613},{"count":4,"name":"propagandas","relevance":0.837924},{"count":4,"name":"odds","relevance":0.804081},{"count":4,"name":"Win","relevance":0.598217},{"count":3,"name":"https:\/\/t.co\/sVcLpf72jp","relevance":0.99549},{"count":3,"name":"https:\/\/t.co\/Nyjn8gsRWk","relevance":0.971161}];


            function initialize() {
                $rootScope.pageClass = 'candidate-page';

                if (vm.candidates.indexOf($stateParams.name) > -1 && !!$stateParams.id) {
                    $rootScope.title = 'Candidate: ' + ($stateParams.name.charAt(0).toUpperCase() + $stateParams.name.slice(1)) + ' - KandiData';

                    prepareSentiments();
                    prepareEmotions();
                    prepareKeywords();
                } else {
                    $state.go('home');
                }
            }

            function prepareSentiments() {
                api.getSentiment($stateParams.id)
                    .then(function(response) {
                        vm.sentiments = response.data;

                        AmCharts.makeChart("sentiment", {
                            "type": "serial",
                            "theme": "light",
                            "dataProvider": vm.sentiments,
                            "valueAxes": [{
                                "axisAlpha": 1,
                                "position": "left"
                            }],
                            "graphs": [
                                {
                                    "id": "g1",
                                    "balloonText": "<b><span style='font-size:14px;'>[[count]]</span></b>",
                                    "bullet": "round",
                                    "bulletSize": 8,
                                    "tickLength": 1,
                                    "lineColor": "#d1655d",
                                    "lineThickness": 2,
                                    "negativeLineColor": "#637bb6",
                                    "type": "smoothedLine",
                                    "minVerticalGap": 1,
                                    "valueField": "sentiment"
                                }
                            ],
                            "chartCursor": {
                                "categoryBalloonDateFormat": "NN",
                                "cursorAlpha": 0,
                                "valueLineEnabled": true,
                                "valueLineBalloonEnabled": true,
                                "valueLineAlpha": 0.5,
                                "fullWidth": true
                            },
                            "dataDateFormat": "NN",
                            "categoryField": "period"
                        });
                    });

                $('a[title="JavaScript charts"]').remove();
            }

            function prepareEmotions() {
               api.getFeels($stateParams.id)
                   .then(function(response) {
                       vm.feels = response.data;


                       console.log(vm.feels);
                       var feels = angular.copy(vm.feels);
                       vm.feels = [];

                       angular.forEach(feels, function(value, key) {
                           vm.feels = vm.feels.concat([{feels: key, value: value}]);
                       });

                       var chart = AmCharts.makeChart("emotions", {
                           "type": "pie",
                           "startDuration": 0,
                           "theme": "light",
                           "addClassNames": true,
                           "defs": {
                               "filter": [{
                                   "id": "shadow",
                                   "width": "300%",
                                   "height": "300%",
                                   "feOffset": {
                                       "result": "offOut",
                                       "in": "SourceAlpha",
                                       "dx": 0,
                                       "dy": 0
                                   },
                                   "feGaussianBlur": {
                                       "result": "blurOut",
                                       "in": "offOut",
                                       "stdDeviation": 3
                                   },
                                   "feBlend": {
                                       "in": "SourceGraphic",
                                       "in2": "blurOut",
                                       "mode": "normal"
                                   }
                               }]
                           },
                           "dataProvider": vm.feels,
                           "valueField": "value",
                           "titleField": "feels",
                           "export": {
                               "enabled": true
                           }
                       });

                       chart.addListener("init", handleInit);

                       chart.addListener("rollOverSlice", function(e) {
                           handleRollOver(e);
                       });

                       function handleInit(){
                           chart.legend.addListener("rollOverItem", handleRollOver);
                       }

                       function handleRollOver(e){
                           var wedge = e.dataItem.wedge.node;
                           wedge.parentNode.appendChild(wedge);
                       }

                       $('a[title="JavaScript charts"]').remove();
                   });
            }

            function prepareKeywords() {
                vm.keywords = vm.keywords.slice(0,9);

                AmCharts.makeChart("keywords", {
                    "type": "serial",
                    "theme": "light",
                    "dataProvider": vm.keywords,
                    "valueAxes": [{
                        "axisAlpha": 0,
                        "position": "left",
                    }],
                    "startDuration": 1,
                    "graphs": [{
                        "balloonText": "<b>[[category]]: [[value]]</b>",
                        "fillColorsField": "color",
                        "fillAlphas": 0.9,
                        "lineAlpha": 0.2,
                        "type": "column",
                        "valueField": "count"
                    }],
                    "chartCursor": {
                        "categoryBalloonEnabled": false,
                        "cursorAlpha": 0,
                        "zoomable": false
                    },
                    "categoryField": "name",
                    "categoryAxis": {
                        "gridPosition": "start",
                        "labelRotation": 45
                    },
                    "export": {
                        "enabled": true
                    }

                });

                $('a[title="JavaScript charts"]').remove();
            }

            initialize();
        }
    ]);
