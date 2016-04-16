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


            function initialize() {
                $rootScope.pageClass = 'candidate-page';

                if (vm.candidates.indexOf($stateParams.name) > -1 && !!$stateParams.id) {
                    $rootScope.title = 'Candidate: ' + ($stateParams.name.charAt(0).toUpperCase() + $stateParams.name.slice(1)) + ' - KandiData';

                    prepareSentimentResult();
                    prepareEmotions();
                } else {
                    $state.go('home');
                }
            }

            function prepareSentimentResult() {
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
            }

            function prepareEmotions() {
               api.getFeels($stateParams.id)
                   .then(function(response) {
                       //vm.feels = response.data;

                       var feels = angular.copy(vm.feels);
                       vm.feels = [];

                       angular.forEach(feels, function(value, key) {
                           vm.feels.concat({feels: key, value: value});
                       });

                       var chart = AmCharts.makeChart("emotions", {
                           "type": "pie",
                           "startDuration": 0,
                           "theme": "light",
                           "addClassNames": true,
                           "legend":{
                               "position":"right",
                               "autoMargins":false
                           },
                           "innerRadius": "30%",
                           "defs": {
                               "filter": [{
                                   "id": "shadow",
                                   "width": "200%",
                                   "height": "200%",
                                   "feOffset": {
                                       "result": "offOut",
                                       "in": "SourceAlpha",
                                       "dx": 0,
                                       "dy": 0
                                   },
                                   "feGaussianBlur": {
                                       "result": "blurOut",
                                       "in": "offOut",
                                       "stdDeviation": 5
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
                   });
            }

            initialize();
        }
    ]);
