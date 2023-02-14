import { NextPage } from 'next';
import { QreChoice } from '../../domain/models/qreChoice';
import { Questionnaire } from '../../domain/models/questionnaire';
import styles from '../../styles/Home.module.scss';

type Result = {
  questionnaire: Questionnaire;
  qreChoices: Omit<QreChoice, 'displayOrder'>[];
};

const Result: NextPage<Result> = ({ questionnaire, qreChoices }) => {
  return (
    <div className={styles.result}>
      <div className={styles.result_bar}>
        {qreChoices.map((qreChoice: Omit<QreChoice, 'displayOrder'>, key: number) => (
          <div
          className={styles.result_num}
          style={{ width: (qreChoice.voteCount / questionnaire.voteCountAll) * 100 + '%' }}
          key={key}
          >
            <h3>{qreChoices[key].body} {key}</h3>
            <span className={styles.number}>
              {Math.round((qreChoice.voteCount / questionnaire.voteCountAll) * 1000) / 10}
              <span className={styles.percent}>%</span>
            </span>
          </div>
        ))}
      </div>
    </div>
  );
};

export default Result;
