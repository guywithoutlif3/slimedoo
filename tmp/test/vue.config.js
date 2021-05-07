module.exports = {
    configureWebpack: {
      devServer: {
        headers: { "Access-Control-Allow-Origin": "*" },
        proxy: 'http://10.80.4.43'
      }
    }
  };