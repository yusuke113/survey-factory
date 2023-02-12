import '../styles/globals.scss';

import type { AppProps } from 'next/app';
import Layout from '../components/Layout';
import { RecoilRoot } from 'recoil';

export default function App({ Component, pageProps }: AppProps) {
  return (
    <RecoilRoot>
      <div className="wrapper">
        <Layout>
          <Component {...pageProps} />
        </Layout>
      </div>
    </RecoilRoot>
  );
}
