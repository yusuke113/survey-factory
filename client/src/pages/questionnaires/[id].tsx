import { GetServerSideProps, NextPage } from "next";
import styles from '../../styles/Home.module.scss';
import { QuestionnaireUseCase } from "../../usecase/questionnaireUseCase";
import { Questionnaire } from "../../models/domain/questionnaire";
import { QreChoice } from "../../models/domain/qreChoice";
import { Tag } from "../../models/domain/tag";

type QuestionnaireDetailPage = {
  questionnaire: Questionnaire,
  qreChoices: QreChoice[],
  tags: Tag[]
}

const QuestionnaireDetailPage: NextPage<QuestionnaireDetailPage> = ({
  questionnaire,
  qreChoices,
  tags
}) => {
  return (
    <>
      <div className={styles.wrapper}>
        <section className={styles.questionnaire}>
          <div className={styles.container}>
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
                    style={{width: qreChoices[0].voteCount / questionnaire.voteCountAll * 100 + '%'}}
                    >
                    <span>
                      {Math.round(qreChoices[0].voteCount / questionnaire.voteCountAll * 100)}%
                    </span>
                </div>
                <div 
                  className={styles.result_2}
                  style={{width: qreChoices[1].voteCount / questionnaire.voteCountAll * 100 + '%'}}
                  >
                    <span>
                      {Math.round(qreChoices[1].voteCount / questionnaire.voteCountAll * 100)}%
                    </span>
                </div>
              </div>
            </div>
            <div className={styles.choices}>
              <ul className={styles.choice_list}>
                {qreChoices.map((qreChoice, key) => (
                  <li key={key}>
                    <p><b>qre_choice_id:</b> {qreChoice.id}</p>
                    <p><b>選択肢:</b> {qreChoice.body}</p>
                    <p><b>投票数:</b> {qreChoice.voteCount}</p>
                  </li>
                ))}
              </ul>
            </div>
          </div>
        </section>
      </div>
    </>
  );
}

export default QuestionnaireDetailPage;

export const getServerSideProps: GetServerSideProps = async (context) => {
  const { id } = context.params || {};
  const useCase = new QuestionnaireUseCase();
  const {data} = await useCase.getQuestionnaire(+id!);

  console.log(data);

  return {
    props: {
      questionnaire: data.questionnaire,
      qreChoices: data.qreChoices,
      tags: data.tags
    }
  }
}
