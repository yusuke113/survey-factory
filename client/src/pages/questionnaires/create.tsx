import { GetServerSideProps, NextPage } from 'next';
import Link from 'next/link';
import { InputTag } from '../../components/formParts/InputTag';
import { InputText } from '../../components/formParts/InputText';
import styles from '../../styles/Home.module.scss';

type QuestionnaireCreatePage = {};

const QuestionnaireCreatePage: NextPage<QuestionnaireCreatePage> = () => {
  return (
    <>
      <div className={styles.questionnaire_create}>
        <div className={styles.content_inner}>
          <div className={styles.questionnaire_container}>
            <section className={styles.questionnaire_section}>
              <h3>アンケートのタイトル</h3>
              <p className={styles.description}>
                アンケートのタイトルと簡潔な説明を設定してください
              </p>
              <InputText
                title="タイトル"
                id="title"
                name="title"
                placeholder="例：目玉焼きには醤油派？ソース派"
                maxLength={30}
              />
              <InputText
                title="アンケートのかんたんな説明"
                id="description"
                name="description"
                placeholder="例：目玉焼きにかける調味料は醤油が好き？それともソースが好き？"
                maxLength={50}
              />
            </section>
            <section className={styles.questionnaire_section}>
              <h3>タグを設定</h3>
              <p className={styles.description}>アンケートに設定するタグを3つまで設定できます</p>
              <InputTag
                title="タグ"
                id="tagName"
                name="tagName"
                placeholder="例：アニメ クレヨンしんちゃん 映画"
                maxLength={20}
              />
            </section>
          </div>
        </div>
      </div>
    </>
  );
};

export default QuestionnaireCreatePage;

// export const getServerSideProps: GetServerSideProps = async () => {
//   const useCase = new QuestionnaireUseCase();
//   const { data } = await useCase.getRankingList('vote', 1, 10);

//   return {
//     props: {
//       questionnaires: data.questionnaires,
//       pager: data.pager,
//     },
//   };
// };
