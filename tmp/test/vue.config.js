module.exports = {
    configureWebpack: {
      devServer: {
        headers: { "Access-Control-Allow-Origin": "*" },
        proxy: 'http://10.80.4.43',
        proxy: 'http://192.168.56.101/'
      }
    }
  };