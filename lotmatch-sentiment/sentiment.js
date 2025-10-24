const HUGGINGFACE_API_URL = 'https://api-inference.huggingface.co/models/cardiffnlp/twitter-roberta-base-sentiment';
const API_KEY = import.meta.env.VITE_HUGGINGFACE_API_KEY; 


export async function analyzeSentiment(text) {
  const response = await fetch(HUGGINGFACE_API_URL, {
    method: 'POST',
    headers: {
      Authorization: `Bearer ${HUGGINGFACE_API_TOKEN}`,
      'Content-Type': 'application/json',
    },
    body: JSON.stringify({ inputs: text })
  });

  if (!response.ok) {
    const error = await response.text();
    throw new Error(`Failed to analyze sentiment: ${error}`);
  }

  const result = await response.json();
  console.log('Raw model output:', result);

  const labelMap = {
    'LABEL_0': 'negative',
    'LABEL_1': 'neutral',
    'LABEL_2': 'positive',
  };

  // Correctly access the inner array and sort
  const scores = result[0];
  const top = scores.sort((a, b) => b.score - a.score)[0];

  return labelMap[top.label] || 'neutral';
}