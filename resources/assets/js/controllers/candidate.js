'use strict';

angular.module('kandidata')
    .controller('CandidateController', [
        '$rootScope',
        '$scope',
        '$stateParams',
        '$state',
        'session',
        'api',
        '$sce',
        '$timeout',
        function ($rootScope, $scope, $stateParams, $state, session, api, $sce, $timeout) {
            var vm = this;

            vm.candidates = ['binay', 'santiago', 'duterte', 'poe', 'roxas'];
            vm.candidatesDescription = {
                binay: 'Vice President Jejomar "Jojo" Binay gained his foothold in Philippine politics when President Corazon C. Aquino appointed him as acting mayor of Makati City after Mayor Nemesio I. Yabut died while in office during the EDSA Revolution in 1986 Binay later got elected as Makati mayor in 1988. He was reelected several times — racking up a total of 21 years as mayor of Makati before he ran for vice president in 2010. Born on November 11, 1942 in Paco, Manila, Binay got his law degree from the University of the Philippines. He also has master\'s degrees from the National Defense College (national security administration), and the Philippine Christian University (management).',
                santiago: 'Sen. Miriam Defensor Santiago gained fame as a tough-talking Immigration chief under the administration of President Corazon C. Aquino. She went on to become a senator from 1995 to 2001 and then in 2004 to the present. She is running for President for the third time. Born on June 15, 1945 in Iloilo City, she got her law degree from the University of the Philippines and obtained her Master of Laws degree and Doctor of Juridical Science from the University of Michigan Law School. Prior to entering public office, Santiago was a political science professor at Trinity College.',
                duterte: 'He may have been born in Maasin, Southern Leyte in the Visayas on March 28, 1945, but Davao City Mayor Rodrigo Duterte made his mark as a politician in Mindanao. He has served several terms as mayor of Davao City, spending a total of over 20 years in the said position. He has also served as congressman and vice mayor. He graduated with a Political Science degree from the Lyceum of the Philippines University in 1968 and got his law degree from San Beda College in Manila in 1972.',
                poe: 'Hers is a life that\'s full of movie-worthy plot twists. As a baby, Sen. Grace Poe was found abandoned at a church in Jaro, Iloilo on September 3, 1968. She was eventually adopted by showbiz couple Fernando Poe Jr. and Susan Roces. She studied Bachelor of Arts in Development Studies at the University of the Philippines-Manila and took up a political science course at Boston College in Massachusetts. In 2010, she was appointed as chair of the Movie and Television Review and Classification Board. She went on to become senator in 2013. Prior to entering public office, when she was still living in the U.S., she worked as a preschool teacher and then as a procurement liaison for the United States Geological Survey office. She also served as the vice president and treasurer of FPJ Productions and Film Archives, Inc.',
                roxas: 'It may be said that Manuel "Mar" Roxas II has always been involved in politics. His father was Senator Gerry Roxas and his grandfather was President Manuel Roxas. Born on May 13, 1957 in Manila, he graduated from the Ateneo de Manila University in 1974 and the Wharton School of Economics at the University of Pennsylvania in 1979. Before entering public office, Roxas worked as an investment banker. In 1993, he was elected as congressman of the 1st District of Capiz. He went on to become senator from 2004 to 2010. He has also held key Cabinet positions as the Secretary of Trade and Industry, Secretary of Transportation and Communications, and Secretary of the Interior and Local Government.'
            };
            vm.candidate = session.getCandidates();
            vm.sentimentsReady = false;
            vm.feelsReady = false;
            vm.keywordsReady = false;

            vm.tweetContent = function(tweet) {
                var tweetDate = new Date(tweet.tweet_date);
                return $sce.trustAsHtml(tweet.text + '<br><small>' + moment(tweetDate).fromNow() + '</small>');
            };

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
                api.getSentiment($stateParams.id, moment().subtract(24, 'hours').format("YYYY-MM-DD, hh:mm:ss"))
                    .then(function (response) {
                        vm.sentiments = response.data;

                        if (!!vm.sentiments.length) {
                            vm.sentimentsReady = true;

                            setTimeout(function () {

                                AmCharts.makeChart("sentiment", {
                                    "type": "serial",
                                    "theme": "light",
                                    "dataProvider": vm.sentiments,
                                    "valueAxes": [{
                                        "axisAlpha": 1,
                                        "labelsEnabled": false,
                                        "position": "left"
                                    }],
                                    "graphs": [
                                        {
                                            "id": "g1",
                                            "balloonText": "<b>Tweets<br><span style='font-size:14px;'>[[count]]</span></b>",
                                            "bullet": "round",
                                            "bulletSize": 8,
                                            "tickLength": 1,
                                            "lineColor": "#d1655d",
                                            "lineThickness": 2,
                                            "negativeLineColor": "#637bb6",
                                            "type": "smoothedLine",
                                            "minVerticalGap": 1,
                                            "valueField": "value"
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
                                    "categoryField": "period",
                                });

                            }, 300);

                            $('a[title="JavaScript charts"]').remove();
                        }

                    });
            }

            function prepareEmotions() {
                api.getFeels($stateParams.id)
                    .then(function (response) {
                        vm.feels = response.data;
                        var feels = angular.copy(vm.feels),
                            feelsZero = true;

                        vm.feels = [];

                        angular.forEach(feels, function (value, key) {
                            if (value > 0) {
                                feelsZero = false;
                            }
                            vm.feels = vm.feels.concat([{feels: key, value: value}]);
                        });

                        if (!feelsZero) {
                            vm.feelsReady = true;

                            feels = angular.copy(vm.feels);

                            angular.forEach(feels, function(value, key) {
                                api.getFeelsTweets($stateParams.id, value.feels)
                                    .then(function(response) {
                                        vm.feels[key]['tweets'] = response.data;
                                    });
                            });

                            setTimeout(function () {
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

                                var handleInit = function () {
                                    chart.legend.addListener("rollOverItem", handleRollOver);
                                };

                                chart.addListener("init", handleInit);

                                var handleRollOver = function (e) {
                                    var wedge = e.dataItem.wedge.node;
                                    wedge.parentNode.appendChild(wedge);
                                };

                                chart.addListener("rollOverSlice", function (e) {
                                    handleRollOver(e);
                                });

                                $('a[title="JavaScript charts"]').remove();

                            }, 300);

                            $timeout(function() {
                                $('.sparkline').each(function() {
                                    var $this = $(this);

                                    $this
                                        .css('display','inline-block')
                                        .css('float','right');
                                    $this.sparkline($this.data('val'), {
                                        type: 'pie',
                                        height: 50
                                    });
                                });
                            }, 1000);
                        }

                    });
            }

            function prepareKeywords() {
                api.getKeywords($stateParams.id)
                    .then(function (response) {
                        vm.keywords = response.data;

                        vm.keywordsReady = true;

                        setTimeout(function () {

                            AmCharts.makeChart("keywords", {
                                "type": "serial",
                                "theme": "light",
                                "dataProvider": vm.keywords,
                                "valueAxes": [{
                                    "axisAlpha": 0,
                                    "position": "left"
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

                        }, 300);
                    });
            }

            initialize();
        }
    ]);
