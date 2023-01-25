import { NextPage } from 'next';
import { Questionnaire } from '../../domain/models/questionnaire';
import styles from '../../styles/Home.module.scss';

type Result = {
  questionnaire: Questionnaire;
  voteCount: number[];
};

const Result: NextPage<Result> = ({ voteCount, questionnaire }) => {
  return (
    <div className={styles.result}>
      <div className={styles.result_bar}>
        {voteCount.map((count: number, key) => (
          <div
            className={styles.result_num}
            style={{ width: (count / questionnaire.voteCountAll) * 100 + '%' }}
            key={key}
          >
            <span className={styles.number}>
              {Math.round((count / questionnaire.voteCountAll) * 1000) / 10}
              <span className={styles.percent}>%</span>
            </span>
          </div>
        ))}
      </div>
    </div>
  );
};

export default Result;
