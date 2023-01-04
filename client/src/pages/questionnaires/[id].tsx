import { GetServerSideProps, NextPage } from 'next';
import styles from '../../styles/Home.module.scss';
import { QreChoice } from '../../domain/models/qreChoice';
import { Questionnaire } from '../../domain/models/questionnaire';
import { Tag } from '../../domain/models/tag';
import { QuestionnaireUseCase } from '../../usecase/questionnaireUseCase';
import { useState } from 'react';

type QuestionnaireDetailPage = {
  questionnaire: Questionnaire;
  qreChoices: QreChoice[];
  tags: Tag[];
};

const QuestionnaireDetailPage: NextPage<QuestionnaireDetailPage> = ({
  questionnaire,
  qreChoices,
  tags,
}) => {

  // 投票チェックボックス判定
  const [selectedOption, setSelectedOption] = useState('');
  const handleOptionChange = (e) => {
    setSelectedOption(e.target.value);
  }

  return (
    <>
      <div className={styles.wrapper}>
        <section className={styles.questionnaire}>
          <div className={styles.md_container}>
            <h2 className={styles.heading_main}>{questionnaire.title}</h2>
            <p className={styles.questionnaire_description}>{questionnaire.description}</p>
            <div className={styles.tags}>
              <ul className={styles.tag_list}>
                {tags.map((tag, key) => (
                  <li className={styles.tag} key={key}>
                    <a href="">{tag.name}</a>
                  </li>
                ))}
              </ul>
            </div>
            <div className={styles.result}>
              <div className={styles.result_bar}>
                <div
                  className={styles.result_1}
                  style={{
                    width: (qreChoices[0].voteCount / questionnaire.voteCountAll) * 100 + '%',
                  }}
                >
                  <span className={styles.number}>
                    {Math.round((qreChoices[0].voteCount / questionnaire.voteCountAll) * 1000) / 10}
                    <span className={styles.percent}>%</span>
                  </span>
                </div>
                <div
                  className={styles.result_2}
                  style={{
                    width: (qreChoices[1].voteCount / questionnaire.voteCountAll) * 100 + '%',
                  }}
                >
                  <span className={styles.number}>
                    {Math.round((qreChoices[1].voteCount / questionnaire.voteCountAll) * 1000) / 10}
                    <span className={styles.percent}>%</span>
                  </span>
                </div>
              </div>
            </div>
            <div className={styles.choices}>
              <form id='choice_form'>
                {qreChoices.map((qreChoice, key) => (
                  <div className={styles.choice_row} key={key}>
                    <label htmlFor={`choice_${qreChoice.id}`}>
                      <input type="radio" name="choice" id={`choice_${qreChoice.id}`} value={qreChoice.id} key={key} checked={selectedOption === `${qreChoice.id}`} onChange={handleOptionChange}/>
                      <p>{qreChoice.body}</p>
                      <p className={styles.choice_number_text}>
                        投票数: {qreChoice.voteCount}
                      </p>
                    </label>
                  </div>
                ))}
                <div className={styles.choice_button_row}>
                  <input type="submit" value="投票する" disabled={selectedOption === ''} className={styles.choice_button}/>
                </div>
              </form>
            </div>
          </div>
        </section>
      </div>
    </>
  );
};

export default QuestionnaireDetailPage;

export const getServerSideProps: GetServerSideProps = async (context) => {
  const { id } = context.params || {};
  const useCase = new QuestionnaireUseCase();

  const { data } = await useCase.getQuestionnaire(+id!);

  return {
    props: {
      questionnaire: data.questionnaire,
      qreChoices: data.qreChoices,
      tags: data.tags,
    },
  };
};
