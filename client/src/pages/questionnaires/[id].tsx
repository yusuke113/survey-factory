import { GetServerSideProps, NextPage } from 'next';
import styles from '../../styles/Home.module.scss';
import { QreChoice } from '../../domain/models/qreChoice';
import { Questionnaire } from '../../domain/models/questionnaire';
import { Tag } from '../../domain/models/tag';
import { QuestionnaireUseCase } from '../../useCase/questionnaireUseCase';
import React, { useState } from 'react';
import { generateUserToken } from '../../utils/generateUserToken';
import { getCookie, setCookie } from 'cookies-next';
import { qreVoteUseCase } from '../../useCase/qreVoteUseCase';
import { useRouter } from 'next/router';
import Result from '../../components/questionnaires/Result';
import BeforeResult from '../../components/questionnaires/BeforeResult';

type QuestionnaireDetailPage = {
  questionnaire: Questionnaire;
  qreChoices: Omit<QreChoice, 'displayOrder'>[];
  tags: Tag[];
};

const useCase = new qreVoteUseCase();

const QuestionnaireDetailPage: NextPage<QuestionnaireDetailPage> = ({
  questionnaire,
  qreChoices,
  tags,
}) => {
  // パスパラメーター取得
  const router = useRouter();
  const { id } = router.query;

  // 投票済みかどうかフラグ
  const [isVoted, setIsVoted] = useState(false);

  // 投票チェックボックス判定
  const [selectedOption, setSelectedOption] = useState('');

  // Cookieからユーザートークンの取得。存在しなければ生成
  const getUserToken = (): string | any => {
    if (getCookie('user_token')) {
      return getCookie('user_token');
    }

    setCookie('user_token', generateUserToken(24));
    const token = getCookie('user_token');

    return token;
  };

  // 投票ボタンChangeイベント
  const handleOptionChange = (e: any) => {
    if (isVoted) {
      return;
    }
    setSelectedOption(e.target.value);
  };

  // 投票するボタン送信イベント
  const handleSubmit = async (e: any) => {
    e.preventDefault();

    // ラジオボタン未選択でのsubmit禁止
    if (selectedOption === '' || isVoted) {
      return;
    }

    const choiceIndex = [...e.target.elements.choice].findIndex((choice) => choice.checked);

    qreChoices[choiceIndex]['voteCount']++;
    questionnaire.voteCountAll++;

    setIsVoted(true);

    try {
      await useCase.postQreVote(Number(id), e.target.elements.choice.value, getUserToken());
    } catch (error: any) {
      console.error(error);
      return;
    }
  };

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
                    <a>{tag.name}</a>
                  </li>
                ))}
              </ul>
            </div>
            {isVoted 
              ? <Result questionnaire={questionnaire} qreChoices={qreChoices} />
              : <BeforeResult />
            }
            <div className={styles.choices}>
              <form id="choice_form" onSubmit={handleSubmit}>
                {qreChoices.map((qreChoice, key) => (
                  <div className={styles.choice_row} key={key}>
                    <label htmlFor={`choice_${qreChoice.id}`}>
                      <input
                        type="radio"
                        name="choice"
                        id={`choice_${qreChoice.id}`}
                        value={qreChoice.id}
                        className={qreChoice.id === Number(selectedOption) ? 'voted' : ''}
                        key={key}
                        checked={selectedOption === `${qreChoice.id}`}
                        onChange={handleOptionChange}
                      />
                      <span className={`${styles.outer} ${isVoted ? styles.voted : ''}`}></span>
                      <p className={styles.choice_body}>{qreChoice.body}</p>
                      {isVoted ? (
                        <p className={styles.choice_number_text}>投票数: {qreChoice.voteCount}</p>
                      ) : (
                        false
                      )}
                    </label>
                  </div>
                ))}
                <div className={styles.choice_button_row}>
                  <input
                    type="submit"
                    value="投票する"
                    disabled={isVoted}
                    className={styles.choice_button}
                  />
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
