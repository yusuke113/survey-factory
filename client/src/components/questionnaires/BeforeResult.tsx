import { NextPage } from 'next';
import styles from '../../styles/Home.module.scss';

const BeforeResult: NextPage = () => {
  return (
    <div className={styles.before_result}>
      <p>投票後結果が表示されます</p>
    </div>
  );
};

export default BeforeResult;
