# KandiData 

A data-driven webapp for Twitter metrics for the Philippines Election 2016 presidential candidates. It's targeted mainly towards the presidentiables themselves and their campaign managers to check the effectiveness of their campaign through analysed Twitter data. The system primarily checks for the candidate's official hashtags and their mentions and the results are analysed individually using AlchemyAPI and AzureML's Text Analysis API service. The results are then presented in an interactive form using fancy charts and uhh, charts. Lol. 

Built with love, Starbucks coffee, RedBull, Coke, and Amber's.

## API Usage

You can access our API so you can do the analysis yourself by using the following endpoints:

*GET api/candidates*
- collection of candidates.


*GET api/tweets*
- collection of tweets, paginated, and sorted by `tweet_date` in descending order. By default, this endpoint will only show tweets with sentiment, keyword, and emotional data. Include key `all=1` so you can pull all the tweets even without them. 

## License

Everything is open-source licensed under the [MIT license](http://opensource.org/licenses/MIT).
