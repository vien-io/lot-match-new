import { analyzeSentiment } from './sentiment.js';

const text = 'Very accomodating staff. People are friendly. Houses looks good';

try {
  const sentiment = await analyzeSentiment(text);
  console.log(`Sentiment: ${sentiment}`);
} catch (err) {
  console.error(err.message);
}