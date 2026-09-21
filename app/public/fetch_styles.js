const https = require('https');
https.get('https://reco.nhaongay.vn/chung-cu/trinity-tower', (res) => {
  let data = '';
  res.on('data', c => data += c);
  res.on('end', () => {
    console.log("Got HTML");
    const gridStyle = data.match(/\.reco-project-hero-gallery[\s\S]*?\}/g);
    console.log(gridStyle);
  });
});
