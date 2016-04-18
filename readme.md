# KandiData 

**http://www.kandidata.tech**

A data-driven webapp for Twitter metrics for the Philippines Election 2016 presidential candidates. It's targeted mainly towards the presidentiables themselves and their campaign managers to check the effectiveness of their campaign through analysed Twitter data. The system primarily checks for the candidate's official hashtags and their mentions and the results are analysed individually using AlchemyAPI and AzureML's Text Analysis API service. The results are then presented in an interactive form using fancy charts and uhh, charts. Lol. 

Built with love, Starbucks coffee, RedBull, Coke, and Amber's.

## API Usage

You can access our API (output is in `json`) so you can do the analysis yourself by using the following endpoints:

*BASE_URL http://www.kandidata.tech/*
- the base url to use to curl against

*GET api/candidates*
- collection of candidates.

*GET api/tweets?[all=1,candidate_id={id}]*
- collection of tweets, paginated, and sorted by `tweet_date` in descending order. By default, this endpoint will only show tweets with sentiment, keyword, and emotional data. Include key `all=1` so you can pull all the tweets even without them. Use the optional parameter `candidate_id` to filter tweets by candidate.

*GET api/{candidate_id}/sentiments?[from={Y-m-d H:i:s},to={Y-m-d H:i:s}*
- collection of computed sentimental data points (positive minus negative) per hour-period by time-range

*GET api/{candidate_id}/tweets?[sentiment={1,-1}]*
- collection of tweets with sentiment data, paginated, and sorted by `tweet_date` in descending order by candidate.
 
Please note that the API doesn't require authentication but it throttles requests by 60 requests per minute.
 
## Additional notes

Emotional analysis for recent tweets are unavailable due to our account at AlchemyAPI hitting the rate limit. We're probably banned by now because we've used multiple api keys (which violates the TOS) in an attempt to have it work for more requests but yeah. We can't pay for the service at the moment so we'll have it sorted out sometime.
AzureML is pretty generous though for having 10k requests per day for a free tier service, but we can't be so sure about how long will that last with the fact that there are just so many tweets pertaining to the presidentiables for the  2016 Philippine Election. 

## Donations?

If you want to donate, we'll be using that to pay for the APIs (eg, Alchemy) development, and the servers.

Bitcoin: `18rZtMhhTCP8W846s4QgHhFYnFja3SBMmd`

## License

Everything is open-source licensed under the [MIT license](http://opensource.org/licenses/MIT).
