import '../styles/globals.scss';

import type { AppProps } from 'next/app';
import Layout from '../components/Layout';

export default function App({ Component, pageProps }: AppProps) {
  return (
    <div className='wrapper'>
      <Layout>
        <Component {...pageProps} />
      </Layout>
    </div>
  );
}
